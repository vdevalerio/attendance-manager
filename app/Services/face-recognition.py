import face_recognition
import cv2
import numpy as np
import mysql.connector
import os
from dotenv import load_dotenv
import argparse

load_dotenv()

host        = os.getenv('DB_HOST', '127.0.0.1')
user        = os.getenv('DB_USERNAME', 'root')
password    = os.getenv('DB_PASSWORD', '')
database    = os.getenv('DB_DATABASE', 'attendance_manager')

mydb = mysql.connector.connect(
    host        = host,
    user        = user,
    password    = password,
    database    = database
)

DIRECTORY_ROOT  = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
IMAGE_PREFIX    = DIRECTORY_ROOT + '/storage/app/public/'

def load_face_encodings_from_db():
    cursor = mydb.cursor()
    cursor.execute("SELECT name, image FROM people")
    known_face_encodings = []
    known_face_names = []

    for name, image in cursor:
        image = IMAGE_PREFIX + image
        if os.path.exists(image):
            image = face_recognition.load_image_file(image)
            face_encoding = face_recognition.face_encodings(image)[0]
            known_face_encodings.append(face_encoding)
            known_face_names.append(name)
        else:
            print(f"Warning: Image file not found at {image}")

    cursor.close()
    return known_face_encodings, known_face_names

parser = argparse.ArgumentParser(description='Start attendance for a group.')
parser.add_argument('group_id', type=int, help='The ID of the group to start attendance for')
args = parser.parse_args()

def create_new_attendance(group_id):
    cursor = mydb.cursor()
    insert_query = "INSERT INTO attendances (group_id, created_at, updated_at) VALUES (%s, NOW(), NOW())"
    cursor.execute(insert_query, (group_id,))
    mydb.commit()
    attendance_id = cursor.lastrowid
    cursor.close()
    return attendance_id

recognized_people_set = set()
def add_person_to_attendance(attendance_id, person_id):
    if person_id not in recognized_people_set:
        cursor = mydb.cursor()
        insert_query = "INSERT INTO attendance_person (attendance_id, person_id, created_at, updated_at) VALUES (%s, %s, NOW(), NOW())"
        cursor.execute(insert_query, (attendance_id, person_id))
        mydb.commit()
        cursor.close()
        recognized_people_set.add(person_id)

def get_person_id_by_name(name):
    cursor = mydb.cursor()
    cursor.execute("SELECT id FROM people WHERE name = %s", (name,))
    result = cursor.fetchone()
    cursor.close()
    return result[0] if result else None


known_face_encodings, known_face_names = load_face_encodings_from_db()

attendance_id = create_new_attendance(args.group_id)

cap = cv2.VideoCapture(0)

unknown_face_count = 0
unknown_face_encodings = []
unknown_face_labels = []

while True:
    ret, frame = cap.read()
    if not ret:
        break

    rgb_frame = np.ascontiguousarray(frame[:, :, ::-1])
    face_locations = face_recognition.face_locations(rgb_frame)

    if face_locations:
        face_encodings = face_recognition.face_encodings(rgb_frame, face_locations)

        for (top, right, bottom, left), face_encoding in zip(face_locations, face_encodings):
            matches = face_recognition.compare_faces(known_face_encodings, face_encoding, tolerance=0.6)
            name = None

            if True in matches:
                first_match_index = matches.index(True)
                name = known_face_names[first_match_index]

                person_id = get_person_id_by_name(name)
                if person_id is not None:
                    add_person_to_attendance(attendance_id, person_id)
            else:
                unknown_matches = face_recognition.compare_faces(unknown_face_encodings, face_encoding, tolerance=0.6)
                if True in unknown_matches:
                    first_unknown_match_index = unknown_matches.index(True)
                    name = unknown_face_labels[first_unknown_match_index]
                else:
                    unknown_face_count += 1
                    unknown_face_encodings.append(face_encoding)
                    unknown_face_label = f"Unknown face {unknown_face_count}"
                    unknown_face_labels.append(unknown_face_label)
                    name = unknown_face_label

            cv2.rectangle(frame, (left, top), (right, bottom), (0, 255, 0), 2)
            cv2.putText(frame, name, (left + 6, bottom - 6), cv2.FONT_HERSHEY_DUPLEX, 0.5, (255, 255, 255), 1)

    cv2.imshow('Webcam', frame)
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

cap.release()
cv2.destroyAllWindows()

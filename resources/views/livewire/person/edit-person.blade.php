<div class="card offset-3 col-6">
    <div class="card-header">
        Edit Person
    </div>
    <div class="card-body">
        <form wire:submit.prevent="editPerson" id="create-person-form">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input wire:model="name" type="text" class="form-control" id="name">
                <div>
                    @error('name')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input wire:model="image" type="file" id="image" name="image" accept="image/*">
                <button type="button" id="startWebcam">Use Webcam</button>
                <div id="webcamContainer" style="display:none;">
                    <video id="webcam" autoplay playsinline width="320" height="240"></video>
                    <button type="button" id="capture">Capture</button>
                    <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>
                </div>

                <input type="hidden" wire:model="image" id="base64image">

                <script>
                    const webcamElement = document.getElementById('webcam');
                    const canvasElement = document.getElementById('canvas');
                    const captureButton = document.getElementById('capture');
                    const startWebcamButton = document.getElementById('startWebcam');
                    const webcamContainer = document.getElementById('webcamContainer');
                    const context = canvasElement.getContext('2d');
                    const base64imageInput = document.getElementById('base64image');
                    let streamReference;

                    startWebcamButton.addEventListener('click', () => {
                        navigator.mediaDevices.getUserMedia({ video: true })
                            .then((stream) => {
                                streamReference = stream;
                                webcamElement.srcObject = stream;
                                webcamContainer.style.display = 'block';
                            })
                            .catch(err => {
                                console.error("Error accessing the webcam", err);
                            });
                    });

                    captureButton.addEventListener('click', () => {
                        context.drawImage(webcamElement, 0, 0, canvas.width, canvas.height);
                        let imageDataURL = canvasElement.toDataURL('image/jpeg');
                        base64imageInput.value = imageDataURL;
                        base64imageInput.dispatchEvent(new Event('input'));
                    });

                    document.getElementById('image').addEventListener('change', function() {
                        this.dispatchEvent(new Event('input'));
                    });

                    document.addEventListener('DOMContentLoaded', function () {
                        const personForm = document.getElementById('create-person-form');

                        personForm.addEventListener('submit', function() {
                            stopWebcam();
                        });
                    });

                    function stopWebcam() {
                        if (streamReference) {
                            streamReference.getTracks().forEach(track => track.stop());
                            webcamContainer.style.display = 'none';
                        }
                    }
                </script>
                <div>
                    @error('image')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" id="submit-form">Submit</button>
            </div>
        </form>
    </div>
</div>
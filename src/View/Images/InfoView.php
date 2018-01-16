<div class="container-fluid">
    <div class="row img-grid justify-content-center pt-2 pt-sm-5">
        <div class="col-12 col-md-8 col-lg-6 col-xl-4">
            <nav class="nav nav-pills nav-justified">
                <a class="nav-item nav-link active bg-info text-white" href="#image-info" id="tab-image-info" data-toggle="pill" role="tab" aria-controls="image-info">
                    <i class="far fa-image" aria-hidden="true"></i>
                    <span>Info</span>
                </a>
                <a class="nav-item nav-link bg-info text-white {{tab-exif-state}}" href="#image-exif" id="tab-image-exif" data-toggle="pill" role="tab" aria-controls="image-exif">
                    <i class="fas fa-info" aria-hidden="true"></i>
                    <span>EXIF</span>
                </a>
            </nav>
            <div class="tab-content">
                <div class="tab-pane fade active show" id="image-info" role="tabpanel" aria-labelledby="tab-image-info">
                    <div class="card">
                        <div class="img-container">
                            <img src="{{image-url}}"/>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">{{image-title}}</li>
                            <li class="list-group-item">{{image-description}}</li>
                            <li class="list-group-item">
                                <span><strong>Größe:</strong> {{image-size}}</span>
                                <span class="ml-3"><strong>Typ:</strong> {{image-type}}</span>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-arrows-alt-v" aria-hidden="true"></i>
                                <span>{{image-height}}</span>
                                <i class="fas fa-arrows-alt-h ml-3" aria-hidden="true"></i>
                                <span>{{image-width}}</span>
                            </li>
                        </ul>
                        <div class="card-body">
                            <a class="btn btn-success btn-sm-block" href="{{URL}}images/download/{{image-id}}"><i class="fas fa-download" aria-hidden="true"></i> Download</a>
                            <a class="btn btn-danger float-right btn-sm-block" href="{{URL}}images/delete/{{image-id}}"><i class="fas fa-trash" aria-hidden="true"></i> Löschen</a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="image-exif" role="tabpanel" aria-labelledby="tab-image-exif">
                    <table class="table table-sm table-striped table-inverse table-bordered" id="image-exif-info">
                        <tr>
                            <td>Aperture Value</td>
                            <td>{{exif-aperture-value}}</td>
                        </tr>
                        <tr>
                            <td>Brightness Value</td>
                            <td>{{exif-brightness-value}}</td>
                        </tr>
                        <tr>
                            <td>Color Space</td>
                            <td>{{exif-color-space}}</td>
                        </tr>
                        <tr>
                            <td>Components Configuration</td>
                            <td>{{exif-components-configuration}}</td>
                        </tr>
                        <tr>
                            <td>Compressed Bits Per Pixel</td>
                            <td>{{exif-compressed-bits-per-pixel}}</td>
                        </tr>
                        <tr>
                            <td>Contrast</td>
                            <td>{{exif-contrast}}</td>
                        </tr>
                        <tr>
                            <td>Custom Rendered</td>
                            <td>{{exif-custom-rendered}}</td>
                        </tr>
                        <tr>
                            <td>Date Time Digitized</td>
                            <td>{{exif-date-time-digitized}}</td>
                        </tr>
                        <tr>
                            <td>Date Time Original</td>
                            <td>{{exif-date-time-original}}</td>
                        </tr>
                        <tr>
                            <td>Digital Zoom Ratio</td>
                            <td>{{exif-digital-zoom-ratio}}</td>
                        </tr>
                        <tr>
                            <td>Exif Version</td>
                            <td>{{exif-version}}</td>
                        </tr>
                        <tr>
                            <td>Exposure Bias Value</td>
                            <td>{{exif-exposure-bias-value}}</td>
                        </tr>
                        <tr>
                            <td>Exposure Index</td>
                            <td>{{exif-exposure-index}}</td>
                        </tr>
                        <tr>
                            <td>Exposure Mode</td>
                            <td>{{exif-exposure-mode}}</td>
                        </tr>
                        <tr>
                            <td>Exposure Program</td>
                            <td>{{exif-exposure-program}}</td>
                        </tr>
                        <tr>
                            <td>Exposure Time</td>
                            <td>{{exif-exposure-time}}</td>
                        </tr>
                        <tr>
                            <td>FNumber</td>
                            <td>{{exif-fnumber}}</td>
                        </tr>
                        <tr>
                            <td>File Source</td>
                            <td>{{exif-file-source}}</td>
                        </tr>
                        <tr>
                            <td>Flash</td>
                            <td>{{exif-flash}}</td>
                        </tr>
                        <tr>
                            <td>Flash Pix Version</td>
                            <td>{{exif-flash-pix-version}}</td>
                        </tr>
                        <tr>
                            <td>Focal Length</td>
                            <td>{{exif-focal-length}}</td>
                        </tr>
                        <tr>
                            <td>Focal Length (in 35mm Film)</td>
                            <td>{{exif-focal-length-in-35mm-film}}</td>
                        </tr>
                        <tr>
                            <td>Focal Plane Resolution Unit</td>
                            <td>{{exif-focal-plane-resolution-unit}}</td>
                        </tr>
                        <tr>
                            <td>Focal Plane Resolution X</td>
                            <td>{{exif-focal-plane-x-resolution}}</td>
                        </tr>
                        <tr>
                            <td>Focal Plane Resolution Y</td>
                            <td>{{exif-focal-plane-y-resolution}}</td>
                        </tr>
                        <tr>
                            <td>Gain Control</td>
                            <td>{{exif-gain-control}}</td>
                        </tr>
                        <tr>
                            <td>Image Length</td>
                            <td>{{exif-image-length}}</td>
                        </tr>
                        <tr>
                            <td>Image Unique ID</td>
                            <td>{{exif-image-unique-id}}</td>
                        </tr>
                        <tr>
                            <td>Image Width</td>
                            <td>{{exif-image-width}}</td>
                        </tr>
                        <tr>
                            <td>ISO Speed Ratings</td>
                            <td>{{exif-iso-speed-ratings}}</td>
                        </tr>
                        <tr>
                            <td>Light Source</td>
                            <td>{{exif-light-source}}</td>
                        </tr>
                        <tr>
                            <td>Maker Note</td>
                            <td>{{exif-maker-note}}</td>
                        </tr>
                        <tr>
                            <td>Max Aperture Value</td>
                            <td>{{exif-max-aperture-value}}</td>
                        </tr>
                        <tr>
                            <td>Metering Mode</td>
                            <td>{{exif-metering-mode}}</td>
                        </tr>
                        <tr>
                            <td>Related Sound File</td>
                            <td>{{exif-related-sound-file}}</td>
                        </tr>
                        <tr>
                            <td>Saturation</td>
                            <td>{{exif-saturation}}</td>
                        </tr>
                        <tr>
                            <td>Scene Capture Type</td>
                            <td>{{exif-scene-capture-type}}</td>
                        </tr>
                        <tr>
                            <td>Scene Type</td>
                            <td>{{exif-scene-type}}</td>
                        </tr>
                        <tr>
                            <td>Sensing Method</td>
                            <td>{{exif-sensing-method}}</td>
                        </tr>
                        <tr>
                            <td>Sharpness</td>
                            <td>{{exif-sharpness}}</td>
                        </tr>
                        <tr>
                            <td>Shutter Speed Value</td>
                            <td>{{exif-shutter-speed-value}}</td>
                        </tr>
                        <tr>
                            <td>Subject Distance Range</td>
                            <td>{{exif-subject-distance-range}}</td>
                        </tr>
                        <tr>
                            <td>Subject Location</td>
                            <td>{{exif-subject-location}}</td>
                        </tr>
                        <tr>
                            <td>Subsec Time</td>
                            <td>{{exif-subsec-time}}</td>
                        </tr>
                        <tr>
                            <td>Subsec Time Digitized</td>
                            <td>{{exif-subsec-time-digitized}}</td>
                        </tr>
                        <tr>
                            <td>Subsec Time Original</td>
                            <td>{{exif-subsec-time-original}}</td>
                        </tr>
                        <tr>
                            <td>User Comment</td>
                            <td>{{exif-user-comment}}</td>
                        </tr>
                        <tr>
                            <td>White Balance</td>
                            <td>{{exif-white-balance}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
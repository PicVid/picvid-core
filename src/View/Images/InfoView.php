<nav class="navbar navbar-expand-md navbar-dark bg-dark" role="navigation">
    <a class="navbar-brand" href="<?= URL ?>">
        <img src="{{LOGO_URL}}" height="30" class="d-inline-block align-top" alt="Logo of PicVid">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <div class="navbar-nav mr-auto">
            <a class="nav-item nav-link" href="<?= URL ?>upload"><i class="fa fa-upload" aria-hidden="true"></i>Upload</a>
            <a class="nav-item nav-link" href="<?= URL ?>images"><i class="fa fa-picture-o" aria-hidden="true"></i>Images</a>
        </div>
        <div class="navbar-nav">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i>{{username}}</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="<?= URL ?>profile"><i class="fa fa-id-card" aria-hidden="true"></i>Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= URL ?>auth/logout"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
                </div>
            </div>
        </div>
    </div>
</nav>
<div class="d-flex justify-content-center mt-5">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-expanded="true">Info</a>
        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-expanded="true">EXIF</a>
    </div>
    <div class="tab-content" id="myTabContent" style="width: 50rem; max-height: 80vh; overflow: auto;">
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home">
            <div class="card">
                <div class="img-container">
                    <img src="{{image-url}}"/>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{image-title}}</li>
                    <li class="list-group-item">{{image-description}}</li>
                    <li class="list-group-item">
                        <i class="fa fa-arrows-v" aria-hidden="true" style="padding:0 7px 0 0;"></i>
                        <span>{{image-height}}</span>
                        <i class="fa fa-arrows-h" aria-hidden="true" style="padding:0 7px 0 20px;"></i>
                        <span>{{image-width}}</span>
                    </li>
                </ul>
                <input type="hidden" name="profile_id" value="25">
                <div class="card-body">
                    <a class="btn btn-sm btn-success" href="<?= URL ?>images/download/{{image-id}}"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
                    <a class="btn btn-sm btn-danger float-right" href="<?= URL ?>images/delete/{{image-id}}"><i class="fa fa-trash" aria-hidden="true"></i> Löschen</a>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile">
            <table class="table table-sm table-striped table-inverse table-bordered">
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
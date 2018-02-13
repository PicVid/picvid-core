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
                        {{exif-table-rows}}
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
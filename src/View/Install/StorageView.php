<div class="bg-overlay"></div>
<a class="credits d-none d-lg-inline-block" href="https://unsplash.com/@cakirchoff?utm_medium=referral&amp;utm_campaign=photographer-credit&amp;utm_content=creditBadge" target="_blank" rel="noopener noreferrer" title="Download free do whatever you want high-resolution photos from Chad Kirchoff">
    <span><i class="fas fa-camera" aria-hidden="true"></i></span>
    <span>Chad Kirchoff</span>
</a>
<div class="container-fluid d-flex flex-column">
    <div class="d-flex flex-row justify-content-center justify-content-sm-center justify-content-md-start justify-content-lg-start justify-content-xl-start p-5">
        <a href="{{URL}}"><img class="logo" height="65" src="{{LOGO_URL}}"/></a>
    </div>
    <div class="d-flex flex-row align-items-center mt-2">
        <form class="ajax container-fluid" method="post" data-action="{{URL}}install/storage">
            <input type="hidden" name="install-task" value="storage-save"/>
            <div class="alert"></div>
            <div class="row justify-content-center">
                <div class="col col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 pb-4 pb-sm-4 pb-md-0 pb-lg-4 d-md-flex flex-lg-row flex-lg-wrap">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-12 col-xl-12 px-0 px-sm-0 pr-md-3 px-lg-0">
                        <div class="card text-white bg-success mb-4">
                            <h4 class="card-header py-3"><i class="fas fa-hdd" aria-hidden="true"></i>Speicher</h4>
                            <div class="card-body bg-dark">
                                <div class="form-group">
                                    <label class="sr-only">max. Dateigröße:</label>
                                    <input class="form-control" name="max_file_size" type="number" placeholder="max. Dateigröße">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only">max. Speicherplatz:</label>
                                    <input class="form-control" name="max_storage_size" type="number" placeholder="max. Speicherplatz">
                                </div>
                            </div>
                        </div>
                        <div class="card text-white bg-success">
                            <h4 class="card-header py-3"><i class="fas fa-random" aria-hidden="true"></i> Sonstiges</h4>
                            <div class="card-body bg-dark">
                                <div class="form-group">
                                    <label class="sr-only">Project Honeypot Key:</label>
                                    <input class="form-control" name="api_project_honeypot_key" type="text" placeholder="Project Honeypot Key"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4 mb-sm-4 justify-content-center">
                <div class="col col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 mb-4 mb-sm-4 mb-md-0">
                    <a class="btn btn-success float-left btn-sm-block" href="{{URL}}install/admin">
                        <i class="fas fa-chevron-left" aria-hidden="true"></i>
                        <span>Administrator</span>
                    </a>
                </div>
                <div class="col col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2">
                    <button class="btn btn-success bg-success float-right btn-sm-block">
                        <i class="fas fa-check"></i>
                        <span>Fertig</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
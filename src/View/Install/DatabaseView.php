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
        <form class="ajax container-fluid" method="post" data-action="{{URL}}install/database">
            <input type="hidden" name="install-task" value="database-save"/>
            <div class="row justify-content-center">
                <div class="col col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                    <div class="alert"></div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4 pb-4 pb-sm-4">
                    <div class="card text-white bg-success">
                        <h4 class="card-header py-3"><i class="fas fa-database" aria-hidden="true"></i>Datenbank (MySQL)</h4>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label class="sr-only" for="database_host">Hostname:</label>
                                <input class="form-control" name="database_host" type="text" placeholder="Hostname" value="{{database-host}}"/>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="database_port">Port:</label>
                                <input class="form-control" name="database_port" type="number" placeholder="Port" value="{{database-port}}"/>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="database_name">Name:</label>
                                <input class="form-control" name="database_name" type="text" placeholder="Name" value="{{database-name}}"/>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="database_user">Benutzername:</label>
                                <input class="form-control" name="database_user" type="text" autocomplete="username" placeholder="Benutzername" value="{{database-user}}"/>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="database_pass">Passwort:</label>
                                <input class="form-control" name="database_pass" type="password" autocomplete="current-password" placeholder="Passwort"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4 mb-sm-4 justify-content-center">
                <div class="col col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2 mb-3 mb-sm-3 mb-md-0">
                    <a class="btn btn-success float-left btn-sm-block" href="{{URL}}install">
                        <i class="fas fa-chevron-left" aria-hidden="true"></i>
                        <span>Voraussetzungen</span>
                    </a>
                </div>
                <div class="col col-12 col-sm-12 col-md-6 col-lg-3 col-xl-2">
                    <button class="btn btn-success bg-success float-right btn-sm-block btn-next">
                        <span>Administrator</span>
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
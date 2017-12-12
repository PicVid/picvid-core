<div class="bg-overlay"></div>
<a class="credits d-none d-lg-inline-block" href="https://unsplash.com/@cindydvr?utm_medium=referral&amp;utm_campaign=photographer-credit&amp;utm_content=creditBadge" target="_blank" rel="noopener noreferrer" title="Download free do whatever you want high-resolution photos from cindy del valle">
    <span><i class="fa fa-camera" aria-hidden="true"></i></span>
    <span>cindy del valle</span>
</a>
<div class="container-fluid d-flex flex-column">
    <div class="d-flex flex-row justify-content-center justify-content-sm-center justify-content-md-start justify-content-lg-start justify-content-xl-start p-5">
        <a href="{{URL}}"><img class="logo" height="65" src="{{LOGO_URL}}"/></a>
    </div>
    <div class="d-flex flex-row align-items-center mt-2">
        <form class="ajax container-fluid" method="post" data-action="{{URL}}install/install" autocomplete="off">
            <div class="alert"></div>
            <div class="row justify-content-center">
                <div class="col col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 pb-4 pb-sm-4">
                    <div class="card text-white bg-success h-100">
                        <h4 class="card-header py-3"><i class="fa fa-database" aria-hidden="true"></i>Datenbank (MySQL)</h4>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label class="sr-only" for="database_host">Hostname:</label>
                                <input class="form-control" name="database_host" type="text" placeholder="Hostname"/>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="database_port">Port:</label>
                                <input class="form-control" name="database_port" type="number" placeholder="Port"/>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="database_name">Name:</label>
                                <input class="form-control" name="database_name" type="text" placeholder="Name"/>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="database_user">Benutzername:</label>
                                <input class="form-control" name="database_user" type="text" placeholder="Benutzername"/>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="database_pass">Passwort:</label>
                                <input class="form-control" name="database_pass" type="password" placeholder="Passwort"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 pb-4 pb-sm-4">
                    <div class="card text-white bg-success mb-4">
                        <h4 class="card-header py-3"><i class="fa fa-user" aria-hidden="true"></i>Administrator</h4>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label class="sr-only" for="database_host">Benutzername:</label>
                                <input class="form-control" name="admin_username" type="text" placeholder="Benutzername"/>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="database_port">E-Mail:</label>
                                <input class="form-control" name="admin_email" type="email" placeholder="E-Mail"/>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="database_name">Passwort:</label>
                                <input class="form-control" name="admin_password" type="password" placeholder="Passwort"/>
                            </div>
                        </div>
                    </div>
                    <div class="card text-white bg-success">
                        <h4 class="card-header py-3"><i class="fa fa-random" aria-hidden="true"></i> Sonstiges</h4>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label class="sr-only">Project Honeypot Key:</label>
                                <input class="form-control" name="api_project_honeypot_key" type="text" placeholder="Project Honeypot Key"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 pb-4 pb-sm-4 pb-md-0 pb-lg-4 d-md-flex flex-lg-row flex-lg-wrap">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-12 col-xl-12 px-0 px-sm-0 pr-md-3 px-lg-0">
                        <div class="card text-white bg-success mb-4">
                            <h4 class="card-header py-3"><i class="fa fa-hdd-o" aria-hidden="true"></i>Speicher</h4>
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
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-12 col-xl-12 px-0 px-sm-0 pl-md-3 px-lg-0">
                        <div class="card text-white bg-success">
                            <h4 class="card-header py-3"><i class="fa fa-sitemap" aria-hidden="true"></i>Umgebung</h4>
                            <div class="card-body bg-dark">
                                <div class="form-group">
                                    <label class="sr-only">Absoluter Pfad:</label>
                                    <input class="form-control" name="absolute_path" type="text" placeholder="absoluter Pfad" value="{{absolute_path}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="sr-only">URL:</label>
                                    <input class="form-control" name="url" type="text" placeholder="absoluter Pfad" value="{{url}}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4 mb-sm-4">
                <div class="col col-12 col-sm-12 col-md-6 mb-4 mb-sm-4 mb-md-0">
                    <a class="btn btn-success float-left btn-sm-block" href="{{URL}}install"><i class="fa fa-chevron-left" aria-hidden="true"></i>Voraussetzungen</a>
                </div>
                <div class="col col-12 col-sm-12 col-md-6">
                    <button class="btn btn-success bg-success float-right btn-sm-block"><i class="fa fa-check" aria-hidden="true"></i>Installieren</button>
                </div>
            </div>
        </form>
    </div>
</div>
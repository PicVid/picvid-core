<div class="bg-overlay dark"></div>
<a class="credits d-none d-lg-inline-block" href="https://unsplash.com/@eugi1492?utm_medium=referral&amp;utm_campaign=photographer-credit&amp;utm_content=creditBadge" target="_blank" rel="noopener noreferrer" title="Download free do whatever you want high-resolution photos from Eugenio Mazzone">
    <span><i class="fas fa-camera" aria-hidden="true"></i></span>
    <span>Eugenio Mazzone</span>
</a>
<div class="container-fluid d-flex flex-column">
    <div class="d-flex flex-row justify-content-center justify-content-sm-center justify-content-md-start justify-content-lg-start justify-content-xl-start p-5">
        <a href="{{URL}}"><img class="logo" height="65" src="{{LOGO_URL}}"/></a>
    </div>
    <div class="row d-flex flex-row mt-2 mx-0 justify-content-center">
        <div class="col col-12 col-sm-12 col-md-12 col-lg-6 col-xl-5 d-flex flex-column justify-content-center mb-4 mb-sm-4 mb-md-4 mb-lg-0 mb-xl-0">
            <div class="mr-0 mr-sm-0 mr-md-0 mr-lg-4 mr-xl-4 align-self-center">
                <h2>PicVid installieren</h2>
                <p>Um PicVid zu installieren werden nur wenige Features vorausgesetzt. Auf der linken Seite findest du eine
                    Liste aller Voraussetzung. Dort kannst du auch auf einen Blick erkennen ob dein Web-Server die
                    Installation unterstützt.</p>
            </div>
        </div>
        <div class="col col-12 col-sm-12 col-md-12 col-lg-6 col-xl-5 mb-4 mb-sm-4 mb-md-4 mb-lg-0 mb-xl-0">
            <div class="card bg-dark text-white">
                <h4 class="card-header bg-success"><i class="fas fa-rocket" aria-hidden="true"></i>Voraussetzungen</h4>
                <div class="card-body px-1">
                    <table class="table table-striped table-dark mb-0">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Empfohlen</th>
                            <th>Aktuell</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-center"><i class="{{php-version-success}}"></i></td>
                            <td>PHP-Version</td>
                            <td>7.1</td>
                            <td>{{php-version}}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><i class="{{pdo-status-success}}"></i></td>
                            <td>Datenbank</td>
                            <td>PDO</td>
                            <td>{{pdo-status}}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><i class="{{openssl-status-success}}"></i></td>
                            <td>OpenSSL</td>
                            <td>Aktiviert</td>
                            <td>{{openssl-status}}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><i class="{{file-upload-status-success}}"></i></td>
                            <td>Datei-Upload</td>
                            <td>Aktiviert</td>
                            <td>{{file-upload-status}}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><i class="fas fa-info" aria-hidden="true"></i></td>
                            <td>max. POST-Größe</td>
                            <td>&gt; 1M</td>
                            <td>{{file-upload-max-post-size}}</td>
                        </tr>
                        <tr>
                            <td class="text-center"><i class="fas fa-info" aria-hidden="true"></i></td>
                            <td>max. Datei-Größe</td>
                            <td>&gt; 1M</td>
                            <td>{{file-upload-max-file-size}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right px-1">
                    <a class="btn btn-success btn-sm-block" href="{{URL}}install/settings"><i class="fas fa-wrench" aria-hidden="true"></i> Einstellungen</a>
                </div>
            </div>
        </div>
    </div>
</div>
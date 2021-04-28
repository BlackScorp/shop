<!DOCTYPE html>
<html lang="de" class="no-js">
<head>
    <title>Vitalij Fotography</title>
    <meta charset="utf-8">
    <style>
        <?= file_get_contents(ASSETS_DIR.'/css/404.css')?>
    </style>
</head>
<body>
    <section class="page_404">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="col-sm-10 col-sm-offset-1  text-center">
                        <div class="four_zero_four_bg">
                            <h1 class="text-center ">404</h1>
                        </div>
                        <div class="contant_box_404">
                            <h3 class="h2">
                                Look like you're lost
                            </h3>

                            <p>
                                Missing configuration file: <b><?= $configFile; ?></b><br />
                                Rename the corresponding example file and adapt the data it contains to your project.
                            </p>

                            <!-- <a href="" class="link_404">Go to Home</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
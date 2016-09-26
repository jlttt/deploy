<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Erreur 404</title>
    <style>

        .coeur {
            width: 465px;
            top: 50%;
            left: 50%;
            margin: -110px 0 0 -253px;
            position: absolute;
            font-family: Arial, Helvetica, sans-serif;
            border: 1px solid #FF6600;
            padding: 20px;
        }

        .erreur {
            text-align: center;
            margin-bottom: 25px;
        }

        .erreur img {
            background-color: #FF6600;
            behavior: url(<?php echo RACINE; ?>_scripts/iepngfix.htc);
        }

        h2 {
            font-size: 20px;
            font-weight: normal;
            color: #FF6600;
            margin: 0;
            padding: 0;
        }

        p {
            font-size: 18px;
            margin: 0 0 15px 0;
        }

        .rdv {
            font-weight: bold;
            font-size: 16px;
            padding-left: 10px;
            background: url(<?php echo RACINE; ?>_erreur/puce.png) 0 5px no-repeat;
        }

        a {
            color: #0032a3;
            text-decoration: underline;
        }

    </style>
    <script type="text/javascript">
        function redirection(page) {
            window.location = page;
        }
        setTimeout('redirection("<?php echo HTTP; ?>")', 12000);
    </script>
</head>

<body>

<div class="coeur">
    <p class="erreur"><img src="<?php echo RACINE; ?>_erreur/erreur404.png" width="318" height="38" alt="erreur 404"/>
    </p>

    <h2>Vous rechercher une page ?</h2>

    <p>L'adresse Internet que vous avez entrée dans votre navigateur ne correspond à aucune active de notre site.</p>

    <p class="rdv">Rendez-vous sur la <a href="<?php echo RACINE; ?>">page d'accueil</a> de <?php echo NOM_SITE; ?></p>
</div>
</body>
</html>
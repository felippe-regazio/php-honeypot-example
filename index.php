<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Honeypot Example</title>
    <style>
        /* required style */
        .ohnohoney{
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            height: 0;
            width: 0;
            z-index: -1;
        }
        /* aesthetics only */
        .container {
            max-width: 1024px;
            width: 100%;
            margin: 0 auto;
        }
        label, input {
            display: block;
            margin-bottom: 16px;
        }
        pre {
            background-color: #f1f1f1; 
            margin-bottom: 20px; 
            max-width: 600px; 
            padding: 12px;
        }
    </style>    
</head>
<body>

    <?php

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);    

        /**
         * Check if a honeypot field was filled on the form
         * By checking on the $_REQUEST for the given field names
         * in the $honeypot_fields. The field names passed on this
         * var must be empty on the REQUEST.
         * 
         * @param $req {Array} must receive $_REQUEST superglobal
         * @return {Boolean} tells if the honeypot catched something
         */
        function honeypot_validade ($req) {
           
            if (!empty($req)) {

                $honeypot_fields = [
                    "name",
                    "email"
                ];

                foreach ($honeypot_fields as $field) {
                    if (isset($req[$field]) && !empty($req[$field])) {
                        return false;
                    }
                }
            }

            return true;
        }

        if (honeypot_validade($_REQUEST)) {
            // The honeypot fields are clean, go on
            $is_spammer = false;
        } else {
            // A spammer filled a honeypot field
            $is_spammer = true;
        }
    ?>

    <!-- START HTML -->

    <div class="container">
        <h2>PHP HONEYPOT EXAMPLE</h2>
        <p>Very simple honeypot example</p>
        <p>This html structure is for demonstration only</p>
        <p>Please read 
            <a href="https://dev.to/felipperegazio/how-to-create-a-simple-honeypot-to-protect-your-web-forms-from-spammers--25n8" target="_blank">
            THIS POST 
            </a>
            to a better understanding of what is going on.
        </p>
        
        <br/><hr/><br/>

    <!-- THE FORM ITSELF -->
    
        <form id="myformid" action="">
            <!-- Real fields -->
            <label for="nameaksljf">Your Name</label>
            <input type="text" id="nameksljf" name="nameksljf" placeholder="Your name here" required maxlength="100">
            <label for="emaillkjkl">Your E-mail</label>
            <input type="text" id="emaillkjkl" name="emaillkjkl" placeholder="Your e-mail here" required>
            <!-- H o n e y p o t -->
            <label class="ohnohoney" for="name"></label>
            <input class="ohnohoney" autocomplete="off" type="text" id="name" name="name" placeholder="Your name here">
            <label class="ohnohoney" for="email"></label>
            <input class="ohnohoney" autocomplete="off" type="email" id="email" name="email" placeholder="Your e-mail here">
            <div class="submit">
                <button type="submit">GO HUMAN</button>
                <button class="botfill" onclick="botFill();">SEND FORM AS A BOT</button>
            </div>
        </form>
        
        <br/><br/><hr/></br>

    <!-- SHOW THE FORM FIELDS SERIALIZED -->

<pre>
    Submited data:
    
    <?= json_encode($_REQUEST, JSON_PRETTY_PRINT); ?>
</pre>
    
    <!-- SHOW THE VALIDATION -->

    <p><?= $is_spammer === true ? '❌ HONEYPOT FOUND A SPAMMER' : '⭐ HONEYPOT FIELDS ARE CLEAN' ?></p>
    
    </div>
    
    <!-- FILL AS A BOT JS -->

    <script>
        
        fillInputs = (type, value) => {
            document.querySelectorAll([`[type="${type}"]`]).forEach(input => {
                input.value = value;
            });
        }

        botFill = () => {
            fillInputs('text', 'John Doe');
            fillInputs('email', 'john@fake.com');
        }
    </script>
</body>
</html>
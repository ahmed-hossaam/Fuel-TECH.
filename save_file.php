<?php

    $image_types = ["png", "jpeg", "jpg", "raw", "heif"];
    $image_size = (10 * 1024 * 1024);

    function save_file($file_input, $image_types, $image_size) {

        try {

            $destinition = "Users_Imgs";

            if (!is_dir($destinition)) {

                mkdir($destinition, 0777, true);
                file_put_contents("Users_Imgs/.htaccess", 
                    "<Files \"*\">\n" .
                        "Order Deny,Allow\n" .
                        "Deny from all\n" .
                    "</Files>\n"
                );
            

            } else if (!is_readable($destinition) || !is_writable($destinition) || !is_executable($destinition)) {

                chmod($destinition, 0777);

            }

            $file_name = $file_input["name"];
            $file_size = $file_input["size"];
            $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

            if (in_array($file_extension, $image_types) && $file_size <= $image_size) {

                do {

                    $unique_name = uniqid("{$_SESSION["UserID"]}_") . ".$file_extension";

                } while (file_exists("Users_Imgs/$unique_name"));

                move_uploaded_file($file_input["tmp_name"], "Users_Imgs/$unique_name");

                return $unique_name;

            }

        } catch (Throwable $error) {}

    }

?>
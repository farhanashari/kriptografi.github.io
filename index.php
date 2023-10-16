<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $password = $_POST['password'];
    $pkey = $_POST['pkey'];
    $usertext = $_POST['usertext'];

    $crypt_method = 'aes-128-cbc';

    $key = hash('sha256', $password);

    $iv = substr(hash('sha256', $pkey), 0, 16);

    if ($_POST['action'] == 'enkripsi') {
        $output = openssl_encrypt($usertext, $crypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if ($_POST['action'] == 'dekripsi') {
        $output = base64_decode($usertext);
        $output = openssl_decrypt($output, $crypt_method, $key, 0, $iv);
    }
    else {
        header('location: ./index.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Enkripsi &amp; Dekripsi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="
    sha384-F3w7mX95Pdgy TmZZME CAngseQB83DFGTowi0iMji WaeVhAn4FJkqJByhZMI3Ahiu" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="my-5">
            <form action="./index.php" method="POST">
                <div class="row row-cols-2">
                    <div class="p-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password" value="<?php echo $password ?? null ?>">
                    </div>
                    <div class="p-3">
                        <label for="pkey" class="form-label">Key</label>
                        <input type="text" class="form-control" id="pkey" name="pkey" value="<?php echo $pkey ?? null ?>">
                    </div>
                </div>
                <div class="mt-3">
                    <label for="usertext" class="form-label">Text</label>
                    <textarea class="form-control" id="usertext" name="usertext" rows="10"><?php echo $output ?? null ?></textarea>
                </div>
                <div class="mt-5 text-end">
                    <button class="btn btn-primary me-2" type="submit" name="action" value="enkripsi">Enkripsi</button>
                    <button class="btn btn-primary" type="submit" name="action" value="dekripsi">Dekripsi</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
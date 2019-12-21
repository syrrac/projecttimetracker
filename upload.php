<?php
    define(ACCESS_KEY, "AKIA5U246MH5P6DEJGB2");
    define(SECRET_KEY, "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");
    session_start();

    require 'vendor/autoload.php';
    use Aws\S3\S3Client;
    use Aws\Exception\AwsException;

    try {
        
        // dispara excessão caso não tenha dados enviados
        if (!isset($_FILES['file'])) {
            throw new Exception("File not uploaded", 1);
        }
        
        //Create a S3Client
        $s3Client = new S3Client([
            'region'  => 'us-west-2',
            'version' => 'latest',
            'credentials' => [
                'key'    => "AKIA5U246MH5P6DEJGB2",
                'secret' => "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",
            ]
        ]);
        // método putObject envia os dados pro bucket selecionado (no caso, teste-marcelo
        $result = $s3Client->putObject([
            'Bucket' => 'dorothy-bucket',
            'Key'    => $_FILES['file']['name'],
            'SourceFile' => $_FILES['file']['tmp_name']
        ]);

        $_SESSION['msg'] = "Object successfully posted, address <a href='{$response['ObjectURL']}'>{$response['ObjectURL']}</a>";
        header("location: form.php");

    } catch(S3Exception $e) {
        echo "Error > {$e->getMessage()}";
    }
?>
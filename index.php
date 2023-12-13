<?php
$pdfText = ''; 
if(isset($_POST['submit'])){ 
    // If file is selected 
    if(!empty($_FILES["pdf_file"]["name"])){ 
        // File upload path 
        $fileName = basename($_FILES["pdf_file"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('pdf'); 
        if(in_array($fileType, $allowTypes)){ 
            // Include autoloader file 
            include 'vendor/autoload.php'; 
             
            // Initialize and load PDF Parser library 
            $parser = new \Smalot\PdfParser\Parser(); 
             
            // Source PDF file to extract text 
            $file = $_FILES["pdf_file"]["tmp_name"]; 
             
            // Parse pdf file using Parser library 
            $pdf = $parser->parseFile($file); 
             
            // Extract text from PDF 
            $text = $pdf->getText(); 
             
            // Add line break 
            $pdfText = nl2br($text); 
        }else{ 
            $statusMsg = '<p>Sorry, only PDF file is allowed to upload.</p>'; 
        } 
    }else{ 
        $statusMsg = '<p>Please select a PDF file to extract text.</p>'; 
    } 
} 
 
// Display text content 
echo $pdfText;
?>

<!DOCTYPE html>
<html>
<head>
    <title>OCR PDF</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">    
    <div class="wrapper">
        <h1>Ekstrak teks dari PDF</h1>
        <div class="cw-frm">
            <?php if(!empty($statusMsg)){?>
            <div class="status-msg <?php echo $status; ?>"><?php echo $statusMsg; ?></div>
        <?php }?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-input">
                <label for="pdf_file">PDF FILE</label>
                <input type="file" name="pdf_file" placeholder="Select file PDF" required="">
            </div>
            <input type="submit" name="submit" class="btn" value="Extract Text">
            </form>
    </div>
</div>
<div class="wrapper-res">
    <?php if(!empty($pdfText)){?>
    <div class="frm-result">
        <p> <?php echo $pdfText; ?></p>
    <div>
        <?php }?>
</body>
</html>
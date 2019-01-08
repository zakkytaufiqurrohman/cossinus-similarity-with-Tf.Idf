<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tugas STKI</title>
    <style>
    form{
        margin-left:37%;
    }
    .text{
         padding: 10px;
         border-radius: 5%;
    }
    h1{
        margin-left:47%;
        margin-top:20%;

    }
    .upload{
       
        padding: 10px;
        box-shadow: 0px 2px 3px rgba(0,0,0,.13) ,1px 2px 2px rgba(0,0,0,.1) , -1px -2px 2px rgba(0,0,0,.05) ;
         border-radius: 5%;
         margin-left:40%;
         margin-rigth:0px;
         text-decoration:none
        
    }
    .about{
      
        padding: 10px;
        box-shadow: 0px 2px 3px rgba(0,0,0,.13) ,1px 2px 2px rgba(0,0,0,.1) , -1px -2px 2px rgba(0,0,0,.05) ;
        border-radius: 5%;
        text-decoration:none
      
    }
    </style>
</head>
<body>
<h1>INDEX</h1>
    <form action="stki.php" method='GET'>
        <input type="text" name="cari" id="" autofocus size='50' class="text">
        <button name='submit' class='text'> submit</button>
    </form>
    <br>
    <br>
    <a href="index2.php" class='upload'>Upload Dokument</a>
    <a href="about_me.php" class="about">About Me &copy 2018</a>


</body>
</html>
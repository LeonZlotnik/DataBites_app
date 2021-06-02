<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style>
         .notificacion{
            position:fixed; bottom:40px; left:45px;
            transform: translateX(-50%);
            background: linear-gradient(to top, #D7627C, #F9CFEC);
            width: 50px;
            height: 50px;
            line-height: 55px;
            font-size: 22px;
            text-align: center;
            color: #fff;
            border-radius: 50%;
            cursor: pointer;
            z-index: 5;
        }
    
        .notificacion a{
            color: white;
            position: relative; top: 1px;
        }
    </style>
</head>

<div class="notificacion">
        <div id="mensage"></div>
</div>

<script>
    document.getElementById('mensage').addEventListener("click", function () {
     
    var not = document.createElement("p")
     not.innerHTML = "Necesita Algo" 
     document.body.appendChild(not); 


     localStorage.setItem(not);
     window.location.href="admin/panel.php"
     
        /*var not = document.createElement("p")
     not.innerHTML = "Necesita Algo" 
     document.body.appendChild(not); 
  
    timer = setTimeout(() =>{
    not.remove()
    },5000);*/
  
});
</script>

</html>
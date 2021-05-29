<!doctype html>
<html lang="en">
<head>
    <title>My name CSV</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

<?=$this->section('content')?>

<script>
    //Проверка на размер загружаемого файла
    var uploadField = document.getElementById("file");

    uploadField.onchange = function() {
        if(this.files[0].size > 1048576){
            alert("Файл слишком большой! Попробуйте ещё раз");
            this.value = "";
        };
    };

</script>
</body>
</html>
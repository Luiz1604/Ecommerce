<?php

include "util.php";
include "_cabecalho.php";
if(isset($_SESSION['sessaoConectado']) && $_SESSION['sessaoConectado'] == true)
    header("Location: ../index.php");
?>
<body>
    
</body>
<?php
    include "../_rodape.php";
    ?>
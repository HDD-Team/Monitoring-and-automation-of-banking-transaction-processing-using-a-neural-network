<?

if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
    if ($filter=="Все") {
        $filter = null;
    } else if ($filter=="Разрешённые") {
        $filter = "SAFE";
    } else if ($filter=="Приостановленные") {
        $filter = "FREEZE";
    } else if ($filter=="Заблокированные") {
        $filter = "STOP";
    }
}

$f = file_get_contents( __DIR__ . DIRECTORY_SEPARATOR . "output.json");
$data = json_decode($f);




if (isset($_GET['safe'])) {
    foreach ($data as $line) {
        if ($line->numbers == $_GET['safe']) {
            $line->status = "SAFE";
            file_put_contents('output.json', json_encode($data));
            echo "<script>window.location.href = \"http://trans-monitor.000.pe\" </script>";
            break;
        }
    }
}

if (isset($_GET['freeze'])) {
    foreach ($data as $line) {
        if ($line->numbers == $_GET['freeze']) {
            $line->status = "FREEZE";
            file_put_contents('output.json', json_encode($data));
            echo "<script>window.location.href = \"http://trans-monitor.000.pe\" </script>";
            break;
        }
    }
}

if (isset($_GET['stop'])) {
    foreach ($data as $line) {
        if ($line->numbers == $_GET['stop']) {
            $line->status = "STOP";
            file_put_contents('output.json', json_encode($data));
            echo "<script>window.location.href = \"http://trans-monitor.000.pe\" </script>";
            break;
        }
    }
}

?>
<html>
    <head>
        <title>
            Мониторинг транзакций
        </title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" type="image/x-icon" href="favicon.ico" />
        <link rel="icon" type="image/svg+xml" href="favicon.svg" />
        <style>
            
            body {
                background-image: url(background.jpg);
                background-repeat: repeat;
            }
            
            #head_block {
                position: fixed;
                background: #26cb16;
                top: 0;
                left: 0;
                width: 100%;
                z-index: 2;
                box-shadow: 0px 0px 20px #444;
            }
            
            #logo {
                position: relative;
                left: 0;
                top: 0;
                width: 50px;
                height: 50px;
                box-shadow: 0px 0px 10px black;
            }
            
            #main_block {
                box-shadow: 0px 0px 20px #444;
                background: aliceblue;
                position: absolute;
                width: 85%;
                min-height: 150%;
                top: 0px;
                margin-top: 50px;
                left: 7.5%;
            }
            
            #sort {
                position: fixed;
                top: 0;
                left: 50px;
                width: 100%;
                min-height: inherit;
                box-shadow: 0px 0px 10px #666;
            }
            
            input.sort {
                color: #f5eb27;
                font-size: 20px;
                background: inherit;
                border: 0px;
                border-bottom: 2px solid #d3c905;
                margin-left: 10px;
                margin-right: 10px; 
                padding-top: 10px;
                cursor: pointer;
                outline: 0;
            }
            
            @media (max-width: 480px) {
                input.sort {
                    font-size: 10px;
                    margin-left: 2px;
                    margin-right: 2px; 
                }
            }  
            
            input.sort:hover {
                transform: scale(1.1, 1.1);
            }
            
                
            
        </style>
        <script>
        
            function safe(line) {
                window.location.href = "http://trans-monitor.000.pe/?safe="+line;
            }
            
            function freeze(line) {
                window.location.href = "http://trans-monitor.000.pe/?freeze="+line;
            }
            
            function stop(line) {
                window.location.href = "http://trans-monitor.000.pe/?stop="+line;
            }
        
        </script>
    </head>
    <body>
        <div id="head_block">
            <a href="https://www.centrinvest.ru/"><img src="logo.jpg" id="logo" /></a>
            <div id="sort">
            <form method="get" action="#">
                <input name="filter" class="sort" type="submit" value="Все"/>
                <input name="filter" class="sort" type="submit" value="Разрешённые"/>
                <input name="filter" class="sort" type="submit" value="Приостановленные"/>
                <input name="filter" class="sort" type="submit" value="Заблокированные"/>
            </form>
            </div>
        </div>
        <div id="main_block">
            <table>
                <tr>
                    <td>
                        step
                    </td>
                    <td>
                        customer
                    </td>
                    <td>
                        age
                    </td>
                    <td>
                        gender
                    </td>
                    <td>
                        zipcodeOri
                    </td>
                    <td>
                        merchant
                    </td>
                    <td>
                        zipMerchant
                    </td>
                    <td>
                        category
                    </td>
                    <td>
                        amount
                    </td>
                    <td>
                        fraud
                    </td>
                    <td>
                        status
                    </td>
                </tr>
                <?
                
                foreach ($data as $line) {
                    if (!isset($filter)) {
                        echo "<tr> <td> $line->step </td> <td> $line->customer </td> <td> $line->age </td> <td> $line->gender </td> <td> $line->zipcodeOri </td> <td> $line->merchant </td> <td> $line->zipMerchant </td> <td> $line->category </td> <td> $line->amount </td> <td> $line->fraud </td> <td> $line->status </td> </tr>";
                        if ($line->status!="SAFE") {
                            echo "<td> <button onclick='safe($line->numbers)'> Разрешить </button> </td>";
                                if ($line->status=="FREEZE") {
                                    echo "<td> <button onclick='stop($line->numbers)'> Запретить </button> </td>";
                                } else {
                                    echo "<td> <button onclick='freeze($line->numbers)'> Заморозить </button> </td>";
                                }
                        }
                    } else {
                        if ($line->status==$filter) {
                            echo "<tr> <td> $line->step </td> <td> $line->customer </td> <td> $line->age </td> <td> $line->gender </td> <td> $line->zipcodeOri </td> <td> $line->merchant </td> <td> $line->zipMerchant </td> <td> $line->category </td> <td> $line->amount </td> <td> $line->fraud </td> <td> $line->status </td> </tr>";
                            if ($line->status!="SAFE") {
                            echo "<td> <button onclick='safe($line->numbers)'> Разрешить </button> </td>";
                                if ($line->status=="FREEZE") {
                                    echo "<td> <button onclick='stop($line->numbers)'> Запретить </button> </td>";
                                } else {
                                    echo "<td> <button onclick='freeze($line->numbers)'> Заморозить </button> </td>";
                                }
                        }
                        }
                    }
                }
                
                ?>
            </table>
        </div>
    </body>
</html>
<?php

if (isset($_GET['filter'])) {
    $filter2 = $_GET['filter'];
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
} else {
    $filter2 = "Все";
}

$f = file_get_contents( __DIR__ . DIRECTORY_SEPARATOR . "output.json");
$data = json_decode($f);




if (isset($_GET['safe'])) {
    foreach ($data as $line) {
        if ($line->numbers == $_GET['safe']) {
            $line->status = "SAFE";
            file_put_contents('output.json', json_encode($data));
            echo "<script>window.location.href = \"http://trans-monitor.000.pe/?filter=$filter2\" </script>";
            break;
        }
    }
}

if (isset($_GET['freeze'])) {
    foreach ($data as $line) {
        if ($line->numbers == $_GET['freeze']) {
            $line->status = "FREEZE";
            file_put_contents('output.json', json_encode($data));
            echo "<script>window.location.href = \"http://trans-monitor.000.pe/?filter=$filter2\" </script>";
            break;
        }
    }
}

if (isset($_GET['stop'])) {
    foreach ($data as $line) {
        if ($line->numbers == $_GET['stop']) {
            $line->status = "STOP";
            file_put_contents('output.json', json_encode($data));
            echo "<script>window.location.href = \"http://trans-monitor.000.pe/?filter=$filter2\" </script>";
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
                background-image: url("background.jpg");
                background-repeat: repeat;
            }
            
            #head_block {
                position: fixed;
                background: white;
                top: 0;
                left: 0;
                width: 100%;
                z-index: 2;
                box-shadow: 0px 0px 20px #444;
                border-bottom-right-radius: 10px;
                border-bottom-left-radius: 10px;
                padding-bottom: 10px;
            }
            
            #head_text {
                width: 100%;
                position: fixed;
                top: 0;
                left: 0;
                text-align: center;
                /*color: #f5ec27;*/
                color: #3aaa35;
                height: 50px;
                padding: 0;
                margin-top: 12.5px;
                font-family: sans-serif;
                font-weight: 750;
                cursor: default;
            }
            
            #logo {
                position: relative;
                left: 0;
                top: 0;
                height: 50px;
                z-index: 3;
                border: 5px solid white;
                padding-right: 15px;
                border-right: 2px dashed #aaa;
                border-bottom: 2px dashed #aaa;
            }
            
            #main_block {
                box-shadow: 0px 0px 20px #444;
                position: absolute;
                width: 65%;
                min-height: 150%;
                top: 0px;
                margin-top: 80px;
                left: 20%;
            }
            
            #sort {
                position: fixed;
                width: 17.5%;
                background: white;
                box-shadow: 0px 0px 10px #666;
                z-index: 3;
                margin: 0;
                border-radius: 7.5px;
                text-align: center;
            }
            
            input.sort {
                font-size: 20px;
                background: inherit;
                border: 0px;
                border-bottom: 2px solid #888;
                margin-left: 10px;
                margin-right: 10px; 
                padding-top: 10px;
                cursor: pointer;
                outline: 0;
                color: black;
            }
            
            
            
            input.sort:hover {
                transform: scale(1.1, 1.1);
                transform: scale(1.1, 1.1);
            }
            
            table {
                background: aliceblue;
                border: 2px solid black;
                position: relative;
                width: 100%;
                text-align: center;
            }
            
            td {
                cursor: default;
                border: 1px solid black;
                padding: 0;
                margin: 0;
            }
            
            tr {
                border 2px solid black;
            }
            
            select {
                background: aliceblue;
                border: 0;
                outline: 0;
                font-family: inherit;
                font-size: inherit;
                width: inherit;
                -webkit-appearance: none;
                appearance: none;
                text-align: center;
                font-weight: 900;
                cursor: pointer;
            }
            
            select:hover {
                transform: scale(1.1, 1.1);
            }
            
            @media (max-width: 550px) {
                
                #main_block {
                    left: 0;
                    width: 100%;
                }
                
                #head_text {
                    font-size: 15px;
                    text-align: right;
                }
                
                input.sort {
                    font-size: 30px;
                }
                
                #sort {
                    width: 100%;
                    bottom: 0;
                    left: 0;
                    height: auto;
                    top: null;
                }
                
                td {
                    font-size: 10px;
                }
            }
            
            @media (min-width: 550px) {
             
                #sort {
                    top: 12.5%;
                    left: 15px;
                }
                
                
            }
            
        </style>
        <script>
        
            
            function change(fun, line) {
                switch (fun) {
                    case "safe":
                        window.location.href = "http://trans-monitor.000.pe/?filter=<?php echo $filter2; ?>&safe="+line;
                        break;
                    case "freeze":
                        window.location.href = "http://trans-monitor.000.pe/?filter=<?php echo $filter2; ?>&freeze="+line;
                        break;
                    case "stop":
                        window.location.href = "http://trans-monitor.000.pe/?filter=<?php echo $filter2; ?>&stop="+line;
                        break;
                }
            }
        
        </script>
    </head>
    <body>
        <div id="head_block">
            <a href="https://www.centrinvest.ru/"><img src="/logo.svg" id="logo" /></a> <h1 id="head_text">МОНИТОРИНГ ТРАНЗАКЦИЙ</h1>
        </div>
            <div id="sort">
            <form method="get" action="#">
                <input name="filter" class="sort" type="submit" value="Все"/><br/>
                <input name="filter" class="sort" type="submit" value="Разрешённые"/><br/>
                <input name="filter" class="sort" type="submit" value="Приостановленные"/><br/>
                <input name="filter" class="sort" type="submit" value="Заблокированные"/>
            </form>
            </div>
        <div id="main_block">
            <table>
                <tr>
                    <td>
                        step
                    </td>
                    <td>
                        Счёт отправителя
                    </td>
                    <td>
                        Возраст
                    </td>
                    <td>
                        Пол
                    </td>
                    <td>
                        Индекс отправителя
                    </td>
                    <td>
                        Счёт получателя
                    </td>
                    <td>
                        Индекс получателя
                    </td>
                    <td>
                        Категория
                    </td>
                    <td>
                        Сумма
                    </td>
                    <td>
                        Статус
                    </td>
                </tr>
                <?php
                
                $gender = array("F"=>"Ж", "M"=>"М");
                $age = array(0=>"до 19", 1=>"19-25", 2=>"26-35", 3=>"36-45", 4=>"46-55", 5=>"56-65", 6=>"65+");
                $status = array("SAFE"=>"Разрешена", "FREEZE"=>"Приостановлена", "STOP"=>"Заблокирована");
                
                foreach ($data as $line) {
                    if (!isset($filter)) {
                        echo "<tr> <td> $line->step </td> <td> $line->customer </td> <td>" , $age[$line->age] , " </td> <td>", $gender[$line->gender] , " </td> <td> $line->zipcodeOri </td> <td> $line->merchant </td> <td> $line->zipMerchant </td> <td>" , str_replace("es_", "", $line->category) , "</td> <td> $line->amount </td>";
                        if ($line->status!="SAFE") {
                            if ($line->status=="FREEZE") {    
                                echo "<td><select onchange='change(this.value, $line->numbers)'> <option value='safe'>Разрешена</option> <option selected value='freeze'>Приостановлена</option> <option value='stop'>Заблокирована</option> </select></td>";
                            } else {
                                echo "<td><select onchange='change(this.value, $line->numbers)'> <option  value='safe'>Разрешена</option> <option selected value='freeze'>Приостановлена</option> <option selected value='stop'>Заблокирована</option> </select></td>";
                            }
                        } else {
                             echo "<td>", $status[$line->status] , " </td>";
                        }
                        echo "</tr>";
                    } else {
                        if ($line->status==$filter) {
                            echo "<tr> <td> $line->step </td> <td> $line->customer </td> <td>" , $age[$line->age] , " </td> <td>", $gender[$line->gender] , " </td> <td> $line->zipcodeOri </td> <td> $line->merchant </td> <td> $line->zipMerchant </td> <td>" , str_replace("es_", "", $line->category) , "</td> <td> $line->amount </td>";
                        if ($line->status!="SAFE") {
                            if ($line->status=="FREEZE") {    
                                echo "<td><select onchange='change(this.value, $line->numbers)'> <option value='safe'>Разрешена</option> <option selected value='freeze'>Приостановлена</option> <option value='stop'>Заблокирована</option> </select></td>";
                            } else {
                                echo "<td><select onchange='change(this.value, $line->numbers)'> <option  value='safe'>Разрешена</option> <option selected value='freeze'>Приостановлена</option> <option selected value='stop'>Заблокирована</option> </select></td>";
                            }
                        } else {
                             echo "<td>", $status[$line->status] , " </td>";
                        }
                        echo "</tr>";
                        }
                    }
                }
                
                ?>
            </table>
        </div>
    </body>
</html>
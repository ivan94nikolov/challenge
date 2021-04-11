<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <form method="post" action="index.php">
                <div class="form-group">
                    <label for="raiting">Order by raiting:</label>
                    <select name="raiting" id="raiting">
                        <option value="high">Highest First</option>
                        <option value="low">Lowest First</option>
                    </select>
                </div>

                
                <div class="form-group">
                <label for="mraiting">Minimum raiting:</label>
                <select name="mraiting" id="mraiting">
                    <option value="5">5</option>
                    <option value="4">4</option>
                    <option value="3">3</option>
                    <option value="2">2</option>
                    <option value="1">1</option>
                </select>
                </div>
                
                <div class="form-group">
                <label for="date">Order by date:</label>
                <select name="date" id="date">
                    <option value="high">Newest first</option>
                    <option value="low">Oldest first</option>
                </select>
                </div>
                
                <div class="form-group">
                <label for="text">Prioritize by text:</label>
                <select name="text" id="text">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                </div>

                <button type="submit" class="btn btn-success">Filter</button>

            </form>
        </div>
        <div class="col-md-8">
            <?php
                //Errors
                if(isset($_POST['raiting'])){
                    $selected = $_POST['raiting'];
                    echo 'You have chosen: ' . $selected . "<br>";
                }
                if(isset($_POST['mraiting'])){
                    $selected = $_POST['mraiting'];
                    echo 'You have chosen: ' . $selected . "<br>";
                }
                if(isset($_POST['date'])){
                    $selected = $_POST['date'];
                    echo 'You have chosen: ' . $selected . "<br>";
                }
                if(isset($_POST['text'])){
                    $selected = $_POST['text'];
                    echo 'You have chosen: ' . $selected . "<br>";
                }
                echo "<br>";


                //Data
                $data = file_get_contents('review.json');
                $data = json_decode($data, true);


                //Functions
                function withText($value){
                    return $value['reviewText'] !== '';
                }
                function minRaiting($value){
                    $compare = $_POST['mraiting'];
                    return $value['rating'] >= $compare;
                }


                //Filtering
                if(isset($_POST['text']) && $_POST['text'] =='yes'){
                    $filteredData = array_filter($data, 'withText');
                }
                else{
                    $filteredData = $data;
                }
                if(isset($_POST['mraiting'])){                    
                    $filteredData = array_filter($filteredData, 'minRaiting');
                }

                //Sort
                if(isset($_POST['date'])){
                    $date = $_POST['date'];
                    if($date=="low"){
                        function sortByDate($a, $b) {
                            return $a['reviewCreatedOnDate'] > $b['reviewCreatedOnDate'];
                        }
                        usort($filteredData, 'sortByDate');
                    }
                    else{
                        function sortByDate($a, $b) {
                            return $b['reviewCreatedOnDate'] > $a['reviewCreatedOnDate'];
                        }
                        usort($filteredData, 'sortByDate');
                    }
                }

                if(isset($_POST['raiting'])){
                    $rating = $_POST['raiting'];
                    if($rating=="low"){
                        function sortByRating($a, $b) {
                            return $a['rating'] > $b['rating'];
                        }
                        usort($filteredData, 'sortByRating');
                    }
                    else{
                        function sortByRating($a, $b) {
                            return $b['rating'] > $a['rating'];
                        }
                        usort($filteredData, 'sortByRating');
                    }
                }

                
                

                //list
                foreach($filteredData as $a){
                    foreach($a as $key => $value){
                            echo $key . " : " . $value . "<br />";                        
                    }    
                    echo "<br>";
                }
            ?>
        </div>
    </div>
</div>    
    
</body>
</html>
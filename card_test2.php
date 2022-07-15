<?php
    if(isset($_POST['page'])){
        include_once 'lib/pagination.class.php'; 
        include_once 'model/ConnDB.php';
        
        $baseURL = 'card_test2.php'; 
        $offset = !empty($_POST['page'])?$_POST['page']:0; 
        $limit = 10;

        $whereSQL = ''; 
        if(!empty($_POST['keywords'])){ 
            $whereSQL = " WHERE (name LIKE '%".$_POST['keywords']."%' OR category LIKE '%".$_POST['keywords']."%' OR detail LIKE '%".$_POST['keywords']."%') "; 
        }
        
        $query   = $conn->query("SELECT COUNT(*) as rowNum FROM product ".$whereSQL); 
        $result  = $query->fetch_assoc(); 
        $rowCount= $result['rowNum'];

        $pagConfig = array( 
            'baseURL' => $baseURL, 
            'totalRows' => $rowCount, 
            'perPage' => $limit,
            'currentPage' => $offset, 
            'contentDiv' => 'dataContainer', 
            'link_func' => 'searchFilter' 
        );
        $pagination =  new Pagination($pagConfig);
        $query = $conn->query("SELECT * FROM product $whereSQL ORDER BY id DESC LIMIT $offset,$limit"); 
    }
?>
<?php require 'meta.php';?>
<style>
    .border_class{
        border: 1px solid #a3a3a3;
        padding: 7px 13px 7px 13px;
        margin-bottom: 50px;
        border-radius: 20px;
    }
</style>

    <!-- Data list container -->
    <div id="dataContainer">
        <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Detail</th>
                <th scope="col">Category</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if($query->num_rows > 0){
                while($row = $query->fetch_assoc()){
                    $offset++;
            ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $row["detail"]; ?></td>
                    <td><?php echo $row["category"]; ?></td>
                </tr>
            <?php 
                } 
            }else{ 
                echo '<tr><td colspan="6">No records found...</td></tr>'; 
            } 
            ?>
        </tbody>
        </table>
        
        <!-- Display pagination links -->
        <div class="d-flex justify-content-center mb-5 mt-3">
            <div class="border_class">
                <?php echo $pagination->createLinks(); ?>
            </div>
        </div>
    </div>

<?php require 'script.php';?>
<?php require 'footer.php';?>
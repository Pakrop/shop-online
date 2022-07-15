<?php
    include_once 'lib/pagination.class.php'; 
    include_once 'model/ConnDB.php';
    
    $baseURL = 'card_test2.php';
    $limit = 10;
    
    $query   = $conn->query("SELECT COUNT(*) as rowNum FROM product"); 
    $result  = $query->fetch_assoc(); 
    $rowCount= $result['rowNum'];

    $pagConfig = array( 
        'baseURL' => $baseURL, 
        'totalRows' => $rowCount, 
        'perPage' => $limit, 
        'contentDiv' => 'dataContainer', 
        'link_func' => 'searchFilter' 
    );
    $pagination =  new Pagination($pagConfig); 
    $query = $conn->query("SELECT * FROM product ORDER BY id DESC LIMIT $limit"); 
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

<div class="search-panel">
    <div class="form-row">
        <div class="form-group col-md-6">
            <input type="text" class="form-control" id="keywords" placeholder="Type keywords..." onkeyup="searchFilter();">
        </div>
    </div>
</div>

<div class="datalist-wrapper mb-5">
    <!-- Loading overlay -->
    <div class="loading-overlay"><div class="overlay-content text-left">Loading...</div></div>

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
</div>



<?php require 'script.php';?>
<script>
    $('.loading-overlay').hide();
function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var keywords = $('#keywords').val();
    $.ajax({
        type: 'POST',
        url: 'card_test2.php',
        data:'page='+page_num+'&keywords='+keywords,
        beforeSend: function () {
            $('.loading-overlay').show();
        },
        success: function (html) {
            $('#dataContainer').html(html);
            $('.loading-overlay').fadeOut("slow");
        }
    });
}
</script>
<?php require 'footer.php';?>
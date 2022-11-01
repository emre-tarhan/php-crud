<?php
require_once 'db.php';
# Create Metodu

if(isset($_POST['add'])){
    $sorgu = $db->prepare("INSERT INTO urunler SET
        name=:name,
        stock=:stock,
        price=:price,
        tax=:tax
    ");
    $sonuc = $sorgu->execute(array(
        'name' => $_POST['name'],
        'stock' => $_POST['stock'],
        'price' => $_POST['price'],
        'tax' => $_POST['tax']
    ));

    if($sonuc) {
        header("location:index.php?success");
    }else{
        header("location:index.php?error");
    }
}


# Update Metodu

if(isset($_POST['edit'])){
    $sorgu = $db->prepare("UPDATE urunler SET
        name=:name,
        stock=:stock,
        price=:price,
        tax=:tax
        WHERE id=:id
    ");
    $sonuc = $sorgu->execute(array(
        'name' => $_POST['name'],
        'stock' => $_POST['stock'],
        'price' => $_POST['price'],
        'tax' => $_POST['tax'],
        'id' => $_POST['id']
    ));

    if($sonuc) {
        header("location:index.php?success");
    }else{
        header("location:index.php?error");
    }
}

# Delete Metodu

if(isset($_GET['sil'])){
    $sorgu = $db->prepare("DELETE FROM urunler WHERE id={$_GET['id']}");
    $sonuc = $sorgu->execute();
    if($sonuc){
        header("location:index.php?success");
    }else{
        header("location:index.php?error");
    }
  }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <button type="button" class="btn btn-success btn-md pull-right mt-5 mb-2" style="margin-left: 90%;" data-bs-toggle="modal" data-bs-target="#addProduct"><span style="font-weight: bold;">+</span> Ürün Ekle</button>
        <!-- Ürün Ekle -->
        <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ürün Ekle</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Ürün Adı</label>
                            <input type="text" name="name" class="form-control" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fiyat</label>
                            <input type="text" name="price" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="text" name="stock" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KDV</label>
                            <input type="text" name="tax" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary w-100" name="add">Kaydet</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kaydetmeden Çık</button>
                </div>
                </div>
            </div>
        </div>

        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Ürün Adı</th>
                <th scope="col">Fiyat</th>
                <th scope="col">Stok</th>
                <th scope="col">KDV</th>
                <th scope="col">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <!-- Read Metodu -->
                <?php
                    foreach (multiple("SELECT * FROM urunler ORDER BY id DESC") as $key => $urun): ?>
                    <tr>
                    <th scope="row"><?= $urun['id'] ?></th>
                    <td><?= $urun['name'] ?></td>
                    <td><?= $urun['price'] ?></td>
                    <td><?= $urun['stock'] ?></td>
                    <td><?= $urun['tax'] ?></td>
                    <td>
                        <a href="#edit" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $urun['id'] ?>">Düzenle</a>
                        <a href="index.php?sil=delete&id=<?=$urun['id']?>" class="btn btn-danger btn-sm">Sil</a>
                    </td>
                </tr>
                <div class="modal fade" id="edit<?= $urun['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Ürünü Düzenle</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Ürün Adı</label>
                                    <input type="text" name="name" class="form-control" value="<?= $urun['name'] ?>" aria-describedby="emailHelp">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Fiyat</label>
                                    <input type="text" name="price" value="<?= $urun['price'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Stok</label>
                                    <input type="text" name="stock" value="<?= $urun['stock'] ?>" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">KDV</label>
                                    <input type="text" name="tax" value="<?= $urun['tax'] ?>" class="form-control">
                                </div>
                                    <input type="text" name="id" value="<?= $urun['id'] ?>" hidden  >
                                <button type="submit" class="btn btn-primary w-100" name="edit">Güncelle</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kaydetmeden Çık</button>
                        </div>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
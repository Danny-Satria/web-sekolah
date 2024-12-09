<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Artikel</title>
    <style>
      .container {
        max-width: 600px;
        margin: 90px auto;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }
      input, textarea {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
      }
      button {
        background: #0056b3;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }
      button:hover {
        background: #003f8a;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h2>Tambah Artikel Baru</h2>
      <form action="proses-tambah.php" method="POST" enctype="multipart/form-data">
        <label for="title">Judul Artikel:</label>
        <input type="text" name="judul" id="title" required />

        <label for="image">Upload Gambar:</label>
        <input type="file" name="gambar" id="image" accept="image/*" />

        <label for="content">Isi Artikel:</label>
        <textarea name="isi" id="content" rows="5" required></textarea>

        <label for="created_by">Dibuat Oleh:</label>
        <input type="text" name="penulis" id="created_by" required />

        <button type="submit">Tambah Artikel</button>
      </form>
    </div>
  </body>
</html>

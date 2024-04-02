<?php
// ファイルの読み込み
require_once "db_connect.php";
require_once "functions.php";
// セッション開始
session_start();

// ログインしているユーザーのIDを取得
$userID = isset($_SESSION["id"]) ? $_SESSION["id"] : '';

// 友達の情報を取得するSQLクエリ
$sql = "SELECT * FROM user_info WHERE user_id IN (SELECT other_user_id FROM friends WHERE user_id = :userID)";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Friends List</title>
    <link rel="stylesheet" href="./showData.css">
</head>
<body class="showData_body" style="background-color: #F0E8F8;">
<div class="navigation">
      <ul>
        <li class="list active">
          <a href="showData.php">
            <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
            <span class="title">HOME</span>
          </a>
        </li>
        <li class="list">
          <a href="MyPage.php">
            <span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
            <span class="title">PROFILE</span>
          </a>
        </li>
        <li class="list">
          <a href="logout.php">
            <span class="icon"
              ><ion-icon name="log-out-outline"></ion-icon
            ></span>
            <span class="title">SIGNOUT</span>
          </a>
        </li>
      </ul>
</div>
<div class="content">
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="">
        <button onclick="searchTable()">Search</button>
    </div>


    <div class="wrapper">
        <table class="table_table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center;">Name</th>
                    <th style="text-align: center;">Affiliation</th>
                    <th style="text-align: center;">Email</th>
                </tr>
            </thead>
            <tbody>
            <tbody id="dataTable">
                <?php foreach($rows as $row): ?>
                    <tr>
                    <td style="text-align: center;">
                        <a href="friendPage.php?user_id=<?php echo $row['user_id']; ?>">
                            <?php echo $row['kanji_name'] . " ( " . $row['romaji_name'] . " )"; ?>
                        </a>
                    </td>
                    
                    <td style="text-align: center;"><?php echo $row['affiliation']; ?></td>
                    <td style="text-align: center;"><?php echo $row['email_address']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </tbody>
        </table>
    </div>
</div>


<!-- 検索機能のJS -->
<script>
function searchTable() {
  // 入力された検索ワードを取得
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("dataTable");
  tr = table.getElementsByTagName("tr");

  // テーブルの各行を検索して非表示または表示を切り替える
  for (i = 0; i < tr.length; i++) {
    var found = false;
    // 各行の各セルを検索
    for (var j = 0; j < tr[i].cells.length; j++) {
      td = tr[i].cells[j];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (doesContainAllChars(txtValue.toUpperCase(), filter.toUpperCase())) {
          found = true;
          break; // 一致するセルが見つかった場合はループを抜けます
        }
      }
    }
    if (found) {
      tr[i].style.display = "";
    } else {
      tr[i].style.display = "none";
    }
  }
}

// 文字列がすべての文字を含んでいるかどうかをチェックするヘルパー関数
function doesContainAllChars(str, searchStr) {
  for (var i = 0; i < searchStr.length; i++) {
    var char = searchStr.charAt(i);
    if (str.indexOf(char) === -1) {
      return false;
    }
  }
  return true;
}
</script>








<!-- サイドバーのJS -->
<script>
    const list = document.querySelectorAll(".list");
    console.log(list);
    function activeLink() {
        list.forEach((item) =>
          item.classList.remove("active")
        );
        this.classList.add("active");
    }

    list.forEach((item) => {
        item.addEventListener("click", activeLink);
    });
</script>

<!-- アイコンの引用元 -->
<script
    type="module"
    src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
></script>
<script
    nomodule
    src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
></script>
</body>
</html>

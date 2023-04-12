<?php
  # scraping books to scrape: https://books.toscrape.com/
  require 'vendor/autoload.php';
  header("Access-Control-Allow-Origin:*");

  $url = $_GET["url"];
  $httpClient = new \simplehtmldom\HtmlWeb();
  // $response = $httpClient->load('https://books.toscrape.com/');
  $response = $httpClient->load($url);
  // echo the title
  echo $response->find('title', 0)->plaintext . "<br><br>";
  // get the prices into an array
  // $prices = [];
  // foreach ($response->find('.row li article div.product_price p.price_color') as $price) {
  //   $prices[] = $price->plaintext;
  // }
  // // echo titles and prices
  // foreach ($response->find('.row li article h3 a') as $key => $title) {
  //   echo "{$title->plaintext} @ {$prices[$key]} <br>";

  // get all the img urls
  $urls = [];
  foreach($response -> find('img') as $img) {
    $urls[] = $url . $img -> src;
  }
  // foreach ($urls as $url) {
  //   echo "{$url} <br>";   
  // }
?>

<table>
  <tr>
    <th>URL</th>
    <th>Download</th>
  </tr>
  <?php foreach ($urls as $url):?>
    <tr>
      <td class="url"><?php echo $url;?></td>
      <td><button onclick="downloadImage('<?php echo $url; ?>');">Download</button></td>
    </tr>
  <?php endforeach;?>
</table>

<div>
  <button onclick="downloadAll();">Download all</button>
</div>

<script>
  function downloadAll() {      
    let elements = document.querySelectorAll(".url")
    for (let i = 0; i < elements.length; i++) {
      let url = elements[i].innerText;
      console.log(url)
      downloadImage(url);
    }
  }
  function downloadImage(url) {
    const splitUrl = url.split("/");
    const filename = splitUrl[splitUrl.length - 1];
    fetch(url,
      {mode : 'cors',
      headers: {'Access-Control-Allow-Origin':'*'}
    })
      .then((response) => {
        response.arrayBuffer().then(function (buffer) {
          const url = window.URL.createObjectURL(new Blob([buffer]));
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute("download", filename); //or any other extension
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        });
      })
      .catch((err) => {
        console.log(err);
      });
  }
</script>
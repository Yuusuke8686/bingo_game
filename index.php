<?php

$bingo = new Bingo;
$bingo->main();

class Bingo
{
  // 定数宣言
  const SIDE_LINE = 'side';
  const DIAGONAL_LINE = 'diagonal';

  private $bingo_flg = false;
  // ビンゴカードのサイズ
  private $card_size = 0;
  // ビンゴカード
  private $bingo_card = [];
  // 選択されたワード
  private $selected_word = [];

  /**
   * [__construct 標準入力の内容を取得する]
   */
  function __construct(){
    // 標準入力からの取得
    while($line = fgets(STDIN)){
      $tmp[] = trim($line);
    }

    // ビンゴカードのサイズ
    $this->card_size = $tmp[0];

    // ビンゴカードの内容を取得する
    for($i = 0; $i < $this->card_size; $i++){
      $this->bingo_card[$i] = explode(" ", $tmp[$i+1]);
    }

    // 選ばれた単語の数
    $N = $tmp[$this->card_size + 1];
    for($j = 0; $j < $N; $j++){
      $this->selected_word[] = $tmp[$j + $this->card_size + 2];
    }
  }

  /**
   * [main メイン関数]
   * @return [type] [description]
   */
  function main(){
    // ビンゴ判定用に縦・横・斜めの配列に切り出す。
    $row_card = [];
    $col_card = [];
    $right_diagonal_card = [];
    $left_diagonal_card = [];

    for($i = 0; $i < $this->card_size; $i++){
      for($j = 0; $j < $this->card_size; $j++){
        // 横
        $row_card[$i][$j] = $this->bingo_card[$i][$j];

        // 縦
        $col_card[$i][$j] = $this->bingo_card[$j][$i];

        // 右下がり斜め
        if($i == $j){
          $right_diagonal_card[] = $this->bingo_card[$k][$l];
        }
        // 左下がり斜め
        if($i + $j == $this->card_size - 1){
          $left_diagonal_card[] = $this->bingo_card[$k][$l];
        }
      }

      // 判定を行う
      $this->checkBingoLine($row_card[$i]);
      $this->checkBingoLine($col_card[$i]);
      $this->checkBingoLine($right_diagonal_card);
      $this->checkBingoLine($left_diagonal_card);

    }

    if($this->bingo_flg){
      echo "yes";
    }
    else {
      echo "no";
    }
  }

  /**
   * [checkBingoLine 該当列がビンゴしているか判定する]
   * @param  array  $bingo_line [description]
   * @return [type]             [description]
   */
  function checkBingoLine(array $bingo_line)
  {
    var_dump($this->selected_word);
    $this->bingo_word = array_intersect($bingo_line, $this->selected_word);
    if(count($this->bingo_word) >= $this->card_size){
      $this->bingo_flg = true;
    }
  }
}

?>

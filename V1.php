<html>
<head>
  <title>Tic Tac Toe with Machine Learning</title>
  <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@3.14.0"></script>
</head>
<body>
  <h1>Tic Tac Toe with Machine Learning</h1>
  <table id="game">
    <tr>
      <td id="0"></td>
      <td id="1"></td>
      <td id="2"></td>
    </tr>
    <tr>
      <td id="3"></td>
      <td id="4"></td>
      <td id="5"></td>
    </tr>
    <tr>
      <td id="6"></td>
      <td id="7"></td>
      <td id="8"></td>
    </tr>
  </table>
  <p id="result"></p>
  <button onclick="reset()">Reset Game</button>
  <script>
    let model;
    let player = 'X';
    let gameBoard = Array(9).fill('');
    const winCombos = [
      [0, 1, 2],
      [3, 4, 5],
      [6, 7, 8],
      [0, 3, 6],
      [1, 4, 7],
      [2, 5, 8],
      [0, 4, 8],
      [2, 4, 6]
    ];

    async function loadModel() {
      model = await tf.loadLayersModel('model/model.json');
    }

    function predict(board) {
      const input = tf.tensor(board, [1, 9]);
      const output = model.predict(input);
      const prediction = Array.from(output.dataSync());
      return prediction.indexOf(Math.max(...prediction));
    }

    function playTurn(square) {
      const index = parseInt(square.id);
      if (gameBoard[index] === '') {
        gameBoard[index] = player;
        square.textContent = player;
        if (checkWin(player)) {
          endGame(false);
        } else if (checkTie()) {
          endGame(true);
        } else {
          player = (player === 'X') ? 'O' : 'X';
          const aiMove = predict(gameBoard);
          gameBoard[aiMove] = player;
          document.getElementById(aiMove.toString()).textContent = player;
          if (checkWin(player)) {
            endGame(false);
          } else if (checkTie()) {
            endGame(true);
          } else {
            player = (player === 'X') ? 'O' : 'X';
          }
        }
      }
    }

    function checkWin(currentPlayer) {
      return winCombos.some((combo) => {
        return combo.every((index) => {
          return gameBoard[index] === currentPlayer;
        });
      });
    }

    function checkTie() {
      return gameBoard.every((square) => {
        return square !== '';
      });
    }

    function endGame(tie) {
      if (tie) {
        document.getElementById('result').textContent = "It's a tie!";
      }

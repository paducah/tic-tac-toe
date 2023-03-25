const board = document.getElementById("board");
const currentPlayerDisplay = document.getElementById("current-player");
const resetButton = document.getElementById("reset-button");
let currentPlayer = "X";
let gameActive = true;
let boardState = Array(9).fill(null);

function createBoard() {
    for (let i = 0; i < 9; i++) {
        const tile = document.createElement("div");
        tile.classList.add("tile");
        tile.addEventListener("click", () => handleTileClick(i));
        board.appendChild(tile);
    }
}

function handleTileClick(i) {
    if (boardState[i] !== null || !gameActive) {
        return;
    }

    boardState[i] = currentPlayer;
    board.children[i].textContent = currentPlayer;
    checkWinner(currentPlayer);

    currentPlayer = currentPlayer === "X" ? "O" : "X";
    currentPlayerDisplay.textContent = "Current Player: " + currentPlayer;
}

function checkWinner(player) {
    const winCombinations = [
        [0, 1, 2],
        [3, 4, 5],
        [6, 7, 8],
        [0, 3, 6],
        [1, 4, 7],
        [2, 5, 8],
        [0, 4, 8],
        [2, 4, 6],
    ];

    for (const combination of winCombinations) {
        const [a, b, c] = combination;
        if (boardState[a] ===

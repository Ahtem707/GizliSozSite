
<div class="container">
    <div class="row">
        <div class="col-8">
            <div id="crosswordsContainer" class="blockContainer">
                <table id="crosswordsTable"></table>
            </div>
        </div>
        <div class="col-3">
            <div class="blockContainer">
                <h3>Size</h3>
                <input id="stepper" type="number" min="1" max="12">
            </div>

            <div class="blockContainer">
                <input type="radio" class="btn-check" name="options-outlined" id="sVertical" autocomplete="off" checked>
                <label class="btn btn-outline-primary" for="sVertical">По вертикали</label>
                <input type="radio" class="btn-check" name="options-outlined" id="sHorizontal" autocomplete="off">
                <label class="btn btn-outline-primary" for="sHorizontal">По горизонтали</label>
            </div>

            <div id="wordInputContainer" class="blockContainer">
                <input id="wordInputK" type="text" placeholder="Кирилица">
                <br><br>
                <input id="wordInputL" type="text" placeholder="Латиница">
                <br><br>
                <button id="okBtn">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- Includes -->
<link rel="stylesheet" href="./Pages/Crosswords/crosswords.css">
<script src="./Pages/Crosswords/crosswords.js"></script>
<script src="./Pages/Crosswords/SetCounts.js"></script>

<script>
    // Подключение
    const input = document.getElementById("stepper")
    const wordInput = document.getElementById("wordInputK")
    const sVertical = document.getElementById("sVertical")
    const sHorizontal = document.getElementById("sHorizontal")
    const tableCells = document.getElementsByClassName("tableCells")
    const okBtn = document.getElementById("okBtn")

    const word = {
        value: String,
        get get() { return this.value },
        set set(value) { 
            this.willSet(this.value)
            this.value = value
            this.didSet(this.value)
        },
        willSet: () => {},
        didSet: () => {}
    }
</script>

<script>
    // Флаги
    var isSelected = false
    var isVertical = true

    // Хранители
    var crossMatrix = null
    var crossTable = {
        chars: new SetCounts(),
        wordObj: [
            {
                word: ['a','h','t','e','m'],
                x: [0,1,2,3,4],
                y: [0,0,0,0,0]
            },
            {
                word: ['m','e','n'],
                x: [0,1,2],
                y: [1,1,1]
            }
        ]
    }
    var activeCell = null
    var size = 6
</script>

<script>
    // События
    sVertical.addEventListener('click', () => {isVertical=true; isSelected=false; updateCellBorders();} )
    sHorizontal.addEventListener('click', () => {isVertical=false; isSelected=false; updateCellBorders();} )
    input.addEventListener('input', (e) => {
        size = e.target.value
        generateCrossword(size)
    })

    okBtn.addEventListener('click', (e) => {
        fetchWord()
        if(activeCell == null) { return }
        const position = activeCell.id.replace(/^.*-/g,'').split(',')
        const x = parseInt(position[1])
        const y = parseInt(position[0])
        let wordObj = {
            word: [],
            x: [],
            y: []
        }
        if(isVertical) {
            for(let i=y; i<size && word.get != ""; i++) {
                const cell = document.getElementById(`tableCell-${i},${x}`)
                let firstChar = word.get.substring(0,1)
                cell.firstElementChild.value = firstChar
                wordObj.word.push(firstChar)
                wordObj.x.push(x)
                wordObj.y.push(i)
                crossMatrix[i][x] = firstChar
                word.set = word.get.slice(1)
            }
        } else {
            for(let i=x; i<size && word.get != ""; i++) {
                const cell = document.getElementById(`tableCell-${y},${i}`)
                let firstChar = word.get.substring(0,1)
                cell.firstElementChild.value = firstChar
                wordObj.word.push(firstChar)
                wordObj.x.push(i)
                wordObj.y.push(y)
                crossMatrix[y][i] = firstChar
                word.set = word.get.slice(1)
            }
        }
        crossTable.wordObj.push(wordObj)
        const setCount = new SetCounts(wordObj.word)
        crossTable.chars.extendSet(setCount)
        updateCellBorders()
        isSelected = false
        activeCell = null
        word.set = ""
        console.log(crossTable)
    })
</script>

<script>
    document.addEventListener('keypress', function(event)
    {
      var code = event.keyCode //|| event.which;
      if (code == 9) {
        const position = activeCell.id.replace(/^.*-/g,'').split(',')
        const x = parseInt(position[1])
        const y = parseInt(position[0])
        if(isVertical) {
            const cell = document.getElementById(`tableCell-${y + 1},${x - 1}`)
            cell.firstElementChild.focus()
            activeElement = cell
        }
      }
    });
</script>

<script>
    // Инициализация
    input.value = size
    generateCrossword(size)

    function generateCrossword(size) {
        crossMatrix = Array(size).fill("")
        for(var i=0; i<size; i++) {
            crossMatrix[i] = Array(size).fill()
        }

        const inputCell = `
            <input 
                class='inputCell'
                type='text'
                maxlength='2'
                onmouseover='inputCellEventMouseOver(this)'
                onmouseout='inputCellEventMouseOut(this)'
                onclick='inputCellEventClick(this)'
            >`
        const table = document.getElementById("crosswordsTable");
        
        var trs = ""
        for(var row=0; row<size; row++) {
            var tds = ""
            for(var col=0; col<size; col++) {
                tds += `<td id='tableCell-${row},${col}' class='tableCells'>${inputCell}</td>`
                if(col < size - 1) {
                    tds += `<td class="spacer"></td>`
                }
            }
            trs += `<tr>${tds}</tr>`
            if(row < size - 1) {
                trs += `<tr class="spacer"></tr>`
            }
        }
        table.innerHTML = trs
    }

    function setupWords() {
        // fields
    }

    function inputCellEventMouseOver(e) {
        if(isSelected) { return }
        const position = e.parentNode.id.replace(/^.*-/g,'').split(',')
        const x = parseInt(position[1])
        const y = parseInt(position[0])
        if(isVertical) {
            for(let i=y; i<input.value; i++) {
                const cell = document.getElementById(`tableCell-${i},${x}`)
                setCellStyle(cell,'focus')
            }
        } else {
            for(let i=x; i<input.value; i++) {
                const cell = document.getElementById(`tableCell-${y},${i}`)
                setCellStyle(cell,'focus')
            }
        }
    }

    function inputCellEventMouseOut(e) {
        if(isSelected) { return }
        const position = e.parentNode.id.replace(/^.*-/g,'').split(',')
        const x = parseInt(position[1])
        const y = parseInt(position[0])
        if(isVertical) {
            for(let i=y; i<input.value; i++) {
                const cell = document.getElementById(`tableCell-${i},${x}`)
                if(crossMatrix[i][x]) {
                    setCellStyle(cell,'fill')
                } else {
                    setCellStyle(cell,'default')
                }
            }
        } else {
            for(let i=x; i<input.value; i++) {
                const cell = document.getElementById(`tableCell-${y},${i}`)
                if(crossMatrix[y][i]) {
                    setCellStyle(cell,'fill')
                } else {
                    setCellStyle(cell,'default')
                }
            }
        }
    }

    function inputCellEventClick(e) {
        isSelected = !isSelected
        activeCell = e.parentNode
    }

    function updateCellBorders() {
        for(let row=0; row<size; row++) {
            for(let col=0; col<size; col++) {
                const cell = document.getElementById(`tableCell-${row},${col}`)
                if(crossMatrix[row][col]) {
                    setCellStyle(cell,'fill')
                } else {
                    setCellStyle(cell,'default')
                }
            }
        }
    }

    function setCellStyle(cell, type) {
        switch(type) {
            case 'default':
                cell.style.borderStyle = 'dashed'
                cell.style.borderColor = 'gray'
                break;
            case 'focus':
                cell.style.borderStyle = 'solid'
                cell.style.borderColor = 'blue'
                break;
            case 'fill':
                cell.style.borderStyle = 'solid'
                cell.style.borderColor = 'black'
                break;
            case 'danger':
                cell.style.borderStyle = 'solid'
                cell.style.borderColor = 'red'
        }
    }
</script>

<style>
    #crosswordsTable tr {
        padding: 5px;
    }
    #crosswordsTable td {
        border-width: 2px;
        border-style: dashed;
        border-color: 'gray';
        width: 50px;
        height: 50px;
        text-align: center;
    }
    #crosswordsTable .spacer {
        border: none;
        width: 20px;
        height: 20px;
    }
    #stepper {
        width: 100px;
    }
    .inputCell {
        width: 100%;
        border: none;
        outline: none;
        text-align: center;
        background-color: inherit;
    }
    .inputCell:focus {
        border: none;
        outline: none;
    }
</style>
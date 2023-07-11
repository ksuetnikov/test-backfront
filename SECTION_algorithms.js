const data = [ 'tr', 'abc', 'bca', 'rt', 'rtr','xxx' ,'op', 'cba', 'po', 'acacb'];

// На выходе должно получиться следующее
const expected = [
    ['tr', 'rt', 'rtr'],
    ['abc','bca', 'cba', 'acacb'],
    ['op', 'po'],
];
function makeAnagrams (data) {
    let word = [];
    let arWords = [];
    let res = [];
    for (let i = 0; i < data.length; i++) {
        word = data[i];
        let temp = Array(word.length);
        for (let a = 0; a < word.length; a++) {
            temp[a] = word[a];
        }
        arWords[i] = temp;
    }
//получили в arWords массив букв каждого слова
    arWords.forEach(function (oneLettersOfWord) {
        let anagr = [];
        for (let i = 0; i < data.length; i++) {
            for (let j = 0; j < data[i].length; j++) {
                if (oneLettersOfWord.includes(data[i][j])) {
                    anagr.push(data[i]);
                } else {
                    // console.log(`Буква ${data[i][j]} из слова ${data[i]}  НЕ содержится в массиве букв ${oneLettersOfWord} `);
                }
            }

        }
        let uniqueNames = new Set(anagr);
        res.push((Array.from(uniqueNames)));
        anagr = [];
    });
   // console.log(res);
    for (let i = 0; i < res.length; i++) {
        for (let j = i; j < res.length; j++) {
            if (JSON.stringify(res[j]) === JSON.stringify(res[i])) {
                res.splice(j, 1);
            }
        }
    }
    console.log(res);
}

makeAnagrams(data);

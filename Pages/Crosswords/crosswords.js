const kInput = document.getElementById("wordInputK")
const lInput = document.getElementById("wordInputL")

// Правила преобразования, исключения
// Е е -> Ye ye (после согласного)
// Е е -> Ye ye (слово - сначала после гласного или ь)
// ---
// Ё ё -> Ö ö (после согласного)
// Ё ё -> Йо йо (слово - сначала в «мягких» словах || слово - сначала в «жестких» словах; после гласного, ь или ъ)
// ---
// О о -> Ö ö (если о - первая буква в "мягком" слове)
// О о -> O o (в остальных случаях)
// ---
// У у -> Ü ü (если у первая буква в "мягком" слове)
// У у -> U u (в остальных случаях)
// ---
// Ю ю -> Ü ü (после согласной)
// Ю ю -> Yü yü (сначала слово, после гласной, или ь в «мягких» словах)
// Ю ю -> Yu yu (сначала слово, после гласной или ь в "жестких" словах)
// ---
// Я я -> Â â (после согласного)
// Я я -> Ya ya (сначала слово, после гласного или ь)

const chars = {
    upperCaseK: ['Гъ', 'Къ', 'Нъ', 'Дж', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ë', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'],
    lowerCaseK: ['гъ', 'къ', 'нъ', 'дж', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'],
    upperCaseL: ['Ğ', 'Q', 'Ñ', 'C', 'A', 'B', 'V', 'G', 'D', 'E', 'Ö', 'J', 'Z', 'İ', 'Y', 'K', 'L', 'M', 'N', 'Ö', 'P', 'R', 'S', 'T', 'Ü', 'F', 'H', 'Ts', 'Ç', 'Ş', 'Şç', 'I', 'E', 'Yü', 'Ya'],
    lowerCaseL: ['ğ', 'q', 'ñ', 'c', 'a', 'b', 'v', 'g', 'd', 'e', 'ö', 'j', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'ö', 'p', 'r', 's', 't', 'ü', 'f', 'h', 'ts', 'ç', 'ş', 'şç', 'ı', 'e', 'yü', 'ya']
}

kInput.addEventListener('input', (e) => {
    e.target.value = e.target.value.replace(/[^а-яА-Я]/g, "")
    lInput.value = e.target.value
    for (let i = 0; i < chars.lowerCaseK.length; i++) {
        lInput.value = lInput.value.replaceAll(chars.lowerCaseK[i], chars.lowerCaseL[i])
        lInput.value = lInput.value.replaceAll(chars.upperCaseK[i], chars.upperCaseL[i])
    }
})

lInput.addEventListener('input', (e) => {
    e.target.value = e.target.value.replace(/[а-яА-Я0-9]/g, "")
    kInput.value = e.target.value
    for (let i = 0; i < chars.lowerCaseK.length; i++) {
        kInput.value = kInput.value.replaceAll(chars.lowerCaseL[i], chars.lowerCaseK[i])
        kInput.value = kInput.value.replaceAll(chars.upperCaseL[i], chars.upperCaseK[i])
    }
})

function fetchWord() {
    // только для латиницы
    word.set = lInput.value
}
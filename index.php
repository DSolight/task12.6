<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];
// Get full name from parts
function getFullnameFromParts($surname, $name, $patronymic) {// Принимаем данные из массива 
    return $surname . ' ' . $name . ' ' . $patronymic; // объединяем их в одну строку
}

foreach ($example_persons_array as $person) { // Запускаем цикл для массива
    $parts = explode(' ', $person['fullname']); // разбиваем строку по пробелам при переборе массива
    echo getFullnameFromParts($parts[0], $parts[1], $parts[2]) . "\n"; // выводим результат
}
// Get parts from full name
function getPartsFromFullname($fullname) { // Принимаем строку из массива с полным именем
    $parts = explode(" ", $fullname); // разделяем её на отдельные части
    return [ // возвращаем результат в виде массива
        'surname' => $parts[0],// фамилия
        'name' => $parts[1],// имя
        'patronymic' => $parts[2]// отчество
    ];
}

foreach ($example_persons_array as $person) { // запускаем цикл
    $parts = getPartsFromFullname($person['fullname']); // применяем функцию 
    echo $parts['surname'].''. $parts['name'].''. $parts['patronymic']. "\n"; // раздельные части массива объединяются в 1 строку
}
// Get short name
function getShortName($fullname) {
    $parts = getPartsFromFullname($fullname);
    return $parts['name'] . ' ' . mb_substr($parts['surname'], 0, 1, 'UTF-8') . '.';
}

foreach ($example_persons_array as $person) { // запускаем цикл
    echo getShortName($person['fullname']). "\n";
}
// Get gender from name
function isMaleNamePart($parts) {
    return (mb_substr($parts, -2) === 'ич') ||
    (mb_substr($parts, -2) === 'са') ||
    (mb_substr($parts, -1) === 'д'); // можно добавлять ещё исключения для определения пола
}

function isFemaleNamePart($parts) {
    return (mb_substr($parts, -3) === 'вна') || 
    (mb_substr($parts, -1) === 'я') ||
    (mb_substr($parts, -1) === 'а'); // можно добавлять ещё исключения для определения пола
}

function getGenderFromName($fullname) {
    $nameParts = getPartsFromFullname($fullname);
    $genderSum = 0;

    foreach ($nameParts as $partName => $parts) {
      if (in_array($partName, ['surname', 'name', 'patronymic'])) {  
        if (isMaleNamePart($parts)) {
            $genderSum++;
        }
        if (isFemaleNamePart($parts)) {
            $genderSum--;
        }
    }
}

    if ($genderSum > 0) {
        return 1; // Мужской пол
    } elseif ($genderSum < 0) {
        return -1; // Женский пол
    } else {
        return 0; // Неопределенный пол
    }
}
foreach ($example_persons_array as $person) {
    echo $person['fullname'] . ': ' . getGenderFromName($person['fullname']) . "\n";// Это проверка
}
// Get gender description
function getGenderDescription($example_persons_array) {
    $maleCount = 0;
    $femaleCount = 0;
    $undefinedCount = 0;
  
    foreach ($example_persons_array as $person) {
        $gender = getGenderFromName($person['fullname']); // Взаимосвязь с функией getGenderFromName
    
        if ($gender === 1) {
            $maleCount++;
        } elseif ($gender === -1) {
            $femaleCount++;
        } else {
            $undefinedCount++;
        }
    }
  
    $total = $maleCount + $femaleCount + $undefinedCount;
  
    $malePercent = round(($maleCount / $total) * 100, 1);
    $femalePercent = round(($femaleCount / $total) * 100, 1);
    $undefinedPercent = round(($undefinedCount / $total) * 100, 1);
  
    return "Гендерный состав аудитории:\nМужчины - $malePercent%\nЖенщины - $femalePercent%\nНе удалось определить - $undefinedPercent%";
}
echo getGenderDescription($example_persons_array); // Это проверка
// "Идеальный подбор пары" пока что не успеваю сделать... Если получится, то сделаю потом.
?> 
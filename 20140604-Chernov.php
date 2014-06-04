<?php

/**
 * Тестовое задание для кандидатов на должность PHP-разработчика
 *
 * Файл представляет собой шаблон для выполнения тестового заданияю Все объявленные
 * методы должны быть реализованы непосредственно здесь. Создание дополнительных
 * собственных методов допускается.
 *
 * Код должен соотвестсовать стандартам кодирования Zend Framework (http://framework.zend.com/manual/ru/coding-standard.html)
 * и работать без генерации предупреждений при включенном режиме error_reporting=E_ALL.
 *
 * После выполнения всех задач файл должен быть переименован в следующий формат:
 * <Date>-<LastName>.php
 *
 * Например, 20131216-Ivanov.php
 *
 * ВНИМАНИЕ!
 *     - На выполнение задания вы не должны тратить более двух-трех дней.
 *     - Файл должен содержать только класс.
 */
class PetrosoftCandidate
{

    /**
     * Задание 1
     *
     * Во входной строке переставить слова в обратном порядке. Например строка
     * «one two three four» должна быть преобразована в «four three two one».
     *
     * @param  string $str    Входная строка
     * @return string         Строка с переставленными словами
     */
    public function task1($str)
    {
        $arr = explode(' ', $str);

        if (!$arr) {
            return $str;
        }

        return implode(' ', array_reverse($arr));
    }

    /**
     * Задание 2
     *
     * В неупорядоченном массиве целых положительных чисел определить положение
     * и длину наиболее длинной группы, представляющей собой перестановку элементов
     * отрезка натурального ряда чисел.
     *
     * Элементы массива
     * 6, 8, 5, 7, 18, 21, 20, 16, 19, 17
     *
     * В нем перестановками являются
     * 6, 8, 5, 7
     * и
     * 18, 21, 20, 16, 19, 17
     *
     * Вторая группа является наибольшей. Индекс первого элемента второй группы равен 4,
     * длина группы равна 6. Метод должен вернуть
     *
     * array(4, 6)
     *
     * @param  array   $list  Входной массив
     * @return array          Массив из двух элементов. Первый — индекс первого элемента
     *                        самой длинной группы, второй — ее длина.
     */
    public function task2($list)
    {
        if (!$list) {
            return null;
        }

        $parts = array();
        $list_count = count($list);

        for ($i = 0; $i < $list_count;) {
            $arr = array_slice($list, $i);
            $arr_count = count($arr);

            for ($j = $arr_count; $j >= 0; $j--) {
                if (array_diff_assoc($arr, array_unique($arr)) || !$this->isArrayFluent($arr)) {
                    array_splice($arr, -1);
                } else {
                    $parts[] = $arr;
                    $i += count($arr);
                    break;
                }
            }
        }

        $max_part = array();
        $max_part_pos = 0;
        $part_pos = 0;

        foreach ($parts as $part) {
            if (!$max_part || count($max_part) < count($part)) {
                $max_part = $part;
                $max_part_pos = $part_pos;
            }
            $part_pos += count($part);
        }

        return array($max_part_pos, count($max_part));
    }

    /**
     * Проверка массива на непрерывность несортированного числового ряда
     *
     * @param array $arr
     * @return boolean
     */
    private function isArrayFluent($arr)
    {
        sort($arr);
        $count = count($arr);

        for ($i = 0; $i < $count; $i++) {
            if ($i > 0 && $arr[$i - 1] + 1 != $arr[$i]) {
                return false;
            }
        }

        return true;
    }

    /**
     * Задание 3
     *
     * Элементы, расположенные на периметре прямоугольной матрицы, отсортировать по часовой
     * стрелке в порядке возрастания, начиная с элемента, расположенного в верхнем левом
     * углу матрицы.
     *
     * Например, для входной матрицы:
     * 1 2 3 4
     * 5 6 7 8
     * 9 0 1 2
     *
     * Должен быть возвращен результат:
     * 0 1 1 2
     * 9 6 7 2
     * 8 5 4 3
     *
     * @param  array $matrix  Прямоугольная матрица
     * @return array          Матрица с отсортированными по периметру элементами
     */
    public function task3($matrix)
    {
        if (!$matrix) {
            return null;
        }

        $width = count($matrix[0]);
        $height = count($matrix);
        $arr = array();

        for ($i = 0; $i < $height; $i++) {
            for ($j = 0; $j < $width; $j++) {
                if ($i == 0 || $i == $height - 1 || $j == 0 || $j == $width - 1) {
                    $arr[] = $matrix[$i][$j];
                }
            }
        }

        sort($arr);

        for ($i = 0; $i < $height; $i++) {
            for ($j = 0; $j < $width; $j++) {
                if ($i == 0) {
                    $matrix[$i][$j] = $arr[$j];
                } elseif ($j == $width - 1) {
                    $matrix[$i][$j] = $arr[$width + $i - 1];
                } elseif ($i == $height - 1) {
                    $matrix[$i][$j] = $arr[2 * $width + $height - 3 - $j];
                } elseif ($j == 0) {
                    $matrix[$i][$j] = $arr[2 * $width + 2 * $height - 4 - $i];
                }
            }
        }

        return $matrix;
    }

    /**
     * Задание 4
     *
     * Сформировать одномерный массив, получающийся при чтении квадратной матрицы по спирали, начиная
     * с верхнего левого элемента матрицы (против часовой стрелки).
     *
     * Например, для входной матрицы:
     *  1  2  3  4
     *  5  6  7  8
     *  9 10 11 12
     * 13 14 15 16
     *
     * Должен быть возвращен результат:
     * 1 5 9 13 14 15 16 12 8 4 3 2 6 10 11 7
     *
     * @param  array $matrix  Входная квадратная матрица
     * @return array          Одномерный массив
     */
    public function task4($matrix, $arr = array())
    {
        if (!$matrix) {
            return null;
        }

        $height = count($matrix);
        $width = count($matrix[0]);
        $offset = count($arr);

        for ($i = 0; $i < $height; $i++) {
            for ($j = 0; $j < $width; $j++) {
                $value = $matrix[$i][$j];
                $arr_count = count($arr);

                if ($j == 0) {
                    $arr[$j + $i + $offset] = $value;
                } elseif ($i == $height - 1) {
                    $arr[$height - 1 + $j + $offset] = $value;
                } elseif ($j == $width - 1) {
                    $arr[$width + 2 * $height - 3 - $i + $offset] = $value;
                } elseif ($i == 0) {
                    $arr[2 * $height + 2 * $width - 4 - $j + $offset] = $value;
                }

                // If added new element
                if ($arr_count < count($arr)) {
                    unset($matrix[$i][$j]);
                }
            }
        }
        ksort($arr);

        // Clean empty elements and reset keys
        $matrix = array_map('array_values', array_values(array_filter($matrix)));

        if ($matrix) {
            return $this->task4($matrix, $arr);
        } else {
            return $arr;
        }
    }

}

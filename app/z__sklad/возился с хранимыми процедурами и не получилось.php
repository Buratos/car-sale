<?php
/*
запускать процедуры получилось, но не получилось заставить процедуру пройтись по циклу.
Не заходит в цикл ну ни как :(
*/
namespace App\Http\Controllers;

use App\Http\Requests\DynamicSearchRequest;
use App\Models\Car\Car;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\DB;

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function countWith__Laravel($params) {
	foreach ($params as $param) {
		$query = DB::table("cars");
		foreach ($param as $key => $value) {
			switch ($key) {
				case "price" :
					$query->where($key, ">", $value);
					break;
				default:
					$query->where($key, $value);
					break;
			}
		}
		$query->selectRaw('count(*)');
		$queryArray[] = $query;
	}
	$summaryQuery = DB::query();
	foreach ($queryArray as $key => $oneQuery) $summaryQuery->selectSub($oneQuery, $key);
	$result = (array)$summaryQuery->first();

	dump($result);
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
function countWith__mysql_stored_procedure($params) {
	$procedure = <<<DDDD
CREATE PROCEDURE count_2D_array(IN params JSON, OUT query VARCHAR(1000))
BEGIN
		DECLARE outer_key_name VARCHAR(255);
    DECLARE inner_key_name VARCHAR(255);
    DECLARE param_value VARCHAR(255);

    SET @query = 'SELECT ';
    SET @comma = '(';

    -- Получаем список внешних ключей в инициативном массиве
    SET @outer_keys = JSON_KEYS(params);

     -- Перебираем все внешние ключи в массиве
    WHILE @outer_keys IS NOT NULL DO
    SET @query = '    ываываыаываыва  ';

        -- Получаем первый внешний ключ из списка
        SET outer_key_name = JSON_UNQUOTE(JSON_EXTRACT(@outer_keys, '$[0]'));

        -- Получаем внутренний ассоциативный массив по внешнему ключу
        SET @inner_array = JSON_EXTRACT(params, CONCAT('$.', outer_key_name));

        -- Получаем список внутренних ключей в ассоциативном массиве
        SET @inner_keys = JSON_KEYS(@inner_array);

        SET @query = CONCAT(@query, @comma, 'SELECT COUNT(*) FROM cars WHERE ');
        SET @and = '';

        -- Перебираем все внутренние ключи в ассоциативном массиве
        WHILE @inner_keys IS NOT NULL DO
            -- Получаем первый внутренний ключ из списка
            SET inner_key_name = JSON_UNQUOTE(JSON_EXTRACT(@inner_keys, '$[0]'));

            -- Получаем значение элемента по внешнему и внутреннему ключам
            SET param_value = JSON_EXTRACT(@inner_array, CONCAT('$[', inner_key_name, ']'));

            -- Ваш код для обработки значения элемента

            -- Групповой запрос с использованием функции COUNT
            SET @query = CONCAT(@query, @and, inner_key_name, ' = ', param_value);
            SET @and = ' AND ';

            -- Удаляем обработанный ключ из списка
            SET @inner_keys = JSON_REMOVE(@inner_keys, '$[0]');
        END WHILE;
        SET @query = CONCAT(@query, ') AS "', outer_key_name, '"');
        SET @comma = ', (';

        -- Удаляем обработанный внешний ключ из списка
        SET @outer_keys = JSON_REMOVE(@outer_keys, '$[0]');
    END WHILE;
    
		SET query = @query;
		-- SET @query = "SELECT * FROM cars WHERE id > 10000 LIMIT 20";
		
    -- Выполняем запрос
    -- PREPARE stmt FROM @query;
    -- EXECUTE stmt;
    -- DEALLOCATE PREPARE stmt;

END;
DDDD;

	// удалить процедуру внутри БД
	DB::select('DROP PROCEDURE IF EXISTS count_2D_array;');
	// записать процедуру в БД
	DB::select($procedure);
	// вызов процедуры
	$test = "пусто";
//	$result = DB::select('CALL count_2D_array(?,?)', [json_encode($params), $test]);
	$result = DB::select('CALL count_2D_array(?, @test)', [json_encode($params)]);
	$test = DB::select('SELECT @test as test')[0]->test;
	dump($result, $test);

	return;

	// внутри процедуры mysql надо сформировать запрос типа такого:
	/*	$query = <<<DDDD

	select (select count(*) from `cars` where `brand_id` = 6 and `number_places` = 3 and `number_doors` = 3) as `0`,
				 (select count(*) from `cars` where `brand_id` = 3 and `number_places` = 4 and `was_in_accident` = 0) as `1`,
				 (select count(*) from `cars` where `brand_id` = 4 and `was_in_accident` = 0) as `2`,
				 (select count(*) from `cars` where `brand_id` = 13 and `number_places` = 5 and `engine_capacity` = 4000 and `number_doors` = 3) as `3`,
				 (select count(*) from `cars` where `brand_id` = 18 and `number_places` = 2 and `number_doors` = 5 and `was_in_accident` = 1) as `4`

	DDDD;*/
}

// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪
class TestController extends Controller {

	public function __invoke() {

		for ($i = 0; $i < 5; $i++) {
			$oneRowParams = [];
			$oneRowParams["brand_id"] = mt_rand(1, 25);
			if (mt_rand(0, 1)) $oneRowParams["number_places"] = mt_rand(2, 7);
			if (mt_rand(0, 1)) $oneRowParams["engine_capacity"] = 1000 + mt_rand(0, 16) * 300;
			if (mt_rand(0, 1)) $oneRowParams["number_doors"] = mt_rand(2, 5);
			if (mt_rand(0, 1)) $oneRowParams["was_in_accident"] = mt_rand(0, 1);
//			if (mt_rand(0, 1)) $oneRowParams["price"] = mt_rand(3000, 80000);
			$params[] = $oneRowParams;
		}

		$json = json_encode($params);

		countWith__Laravel($params);
		countWith__mysql_stored_procedure($params);
	}


// ▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪▪

	public
	function __construct() {
		echo '<head><title>TEST</title>';
		echo "<link rel='icon' href='" . asset('/img/favicons/favicon_test.png') . "' type='image/x-icon'>";
//		echo '<script src="' . asset('/plugins/jquery-3.7.0.min.js') . '" type="text/javascript"></script>';
		echo '<link href="' . asset('/css/test.css') . '" rel="stylesheet"/>';
		echo '<script src="' . asset('/plugins/live_only_JS_and_css.js') . '" type="text/javascript"></script>';
		echo '<script src="' . asset('/js/test.js') . '" type="text/javascript"></script>';
		echo '</head>';
		return;
		echo '<body><form action="/test_get"><input type="text" name="search_str" val="rel"><input type="submit" id="submit" value="SUBMIT"></form></body>';

		return;
//		cleanPhotosOfGarbage();
//		cleanDiskOf_temp_photos_Garbage(24 * 1);

	}


}





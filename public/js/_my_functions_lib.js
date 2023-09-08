/*************************************************************************
 ******    СПИСОК ФУНКЦИЙ в этом файле ***********************************

// Строка за строкой выводит в консоль содержимое объекта FormData, имя ключа и значение
function console_log_formdata(form_data_object) {

  // Returns сумму элементов массива, всех или из указанного диапазона
 // В параметрах указывать НОМЕРА элементов массива, а не смещения
 function get_array_elements_sum(elem1 = 1, elem2, arr) {

 // возращает строку, из которой удалены все пробельные символы, не только ' '
 function remove_spaces(str) {

 // скрывает объект HTML путём добавления класса d-none. Этот класс конечно же должен быть объявлен в стилях
 function hide(id) {

 // убирает класс d-none. Этот класс конечно же должен быть объявлен в стилях
 function show(id) {

 // скрывает объект HTML путём добавления в свойство style "display: none"
 function display_none(id) {

 // убирает из свойства style у тэга строку "display: none"
 function display_none_off(id) {

 function get_random_int(minimum, maximum) {
 function get_random_str(...args) {
 function get_random_text(words_number)

 // делает у строки первую букву заглавной, остальный в нижнем регистре
 function upper_first_letter(string) {
 function textWidth(text, fontProp) {
 function textHeight(text, fontProp) {
 function conlog(...param) {
 function clog(...param) {
 function cinfo(...param) {
 function cwarn(...param) {
 function cerror(...param) {
 function cdir(...param) {
 FastClone.clone(object);

 function clone_obj(obj) {
 function undef(anyvar) {

 возвращает true, если переменная - это пустой объект / массив / строка
 function empty(anyvar) {
 // подготавливает текст для вставляния в код html.
 // подменяются кавычки всякие, переводы строки и др
 function str_prepare_to_html(str) {

 // кодирует в строке нижеуказанные символы во избежание некоторых трабл потом
 function str_escape_encode(text) {

 // декодирует в строке нижеуказанные символы / ЭТА ФУНКЦИЯ НЕ ПРОВЕРЯЛАСЬ В РАБОТЕ
 function str_escape_decode(str) {

 // для отладки. Издаёт короткий звук
 function bip() {

 // делает паузу в выполнении скрипта в любом месте
 async function delay(ms) {   НАВЕРНО НЕ РАБОТАЕТ

 получает объект JQuery и ищет его предки, соответствующие либо условию
 function find_parent(JQuery_object, classes_or_object) {

 // ************************************************************************************
// в зависимости размера вьюпорта возвращает одно из 3х значений:
//  "mobile" - для телефона или мелкого планшета
//  "pad" - для планшета побольше
//  "desktop" - для компьютера
function getViewportSize() {

// вернёт true, если это вьюпорт телефона / планшета / компьютера вертикально
function isMobileViewport()
function isPadViewport()
function isDesktopViewport()

добавляет ПАРАМЕТР в строку адреса http.
name=value
function addParamInURL(name, value) {
*/


/*
 Строка за строкой выводит в консоль содержимое объекта FormData, имя ключа и значение
 */
function console_log_formdata(form_data_object) {
  console.log("******** FormData object *******************");
  console.log("   KEY ↓            |  VALUE ↓");
  for (var key_value of form_data_object.entries()) {
    console.log(`${key_value[0]}  |  ${key_value[1]}`);
  }
  console.log("********************************************");
}

/*
 КЛОНИРУЕТ ОБЪЕКТ любой вложенности и с любыми элеменами
 */
function clone_obj(obj) {
  var new_obj;
  if (typeof obj != "object") return obj;
  if (Array.isArray(obj)) new_obj = []; else new_obj = {};

  for (let key in obj) {
    if (typeof obj[key] == "object") {
      if (Array.isArray(obj[key])) {                    // ARRAY
        new_obj[key] = [];
        for (let i = 0; i < obj[key].length; i++) {
          if (typeof obj[key][i] == "object") new_obj[key].push(clone_obj(obj[key][i])); else new_obj[key].push(obj[key][i]);
        }
      }
      else {
        new_obj[key] = clone_obj(obj[key]);
      }       // OBJECT
    }
    else {
      new_obj[key] = obj[key];
    }
  }
  return new_obj;
}

// отрезает от конца 2 символа в строках типа "149.242px" и возвращает ЧИСЛО (не строку)
function cutoff__px(str) {
  //  return +str.slice(0, str.length - 2);
  return parseFloat(str);
}

// определяет тип устройства по размеру ширины экрана, возвращает строку phone / tablet / pc
function determine_device_type() {
  if (screen.width >= 1024 && screen.height >= 960) {
    return "pc";
  }
  else {
    var width = (screen.width < screen.height) ? screen.width : screen.height;
    if (width < 768) return "phone"; else if (width < 1024) return "tablet"; else return "pc";
  }
}

/*
 возвращает true, если переменная равна null или undefined
 но НЕЛЬЗЯ применять к необъявленным переменным
 */
function undef(anyvar) {
  return (anyvar == null || anyvar === undefined);
}

/*
 возвращает true, если переменная - это пустой объект / массив / строка
 */
function empty(anyvar) {
  return (anyvar == "" || anyvar == [] || anyvar == {});
}

// подготавливает текст для вставляния в код html.
// подменяются кавычки всякие, переводы строки и др
function str_prepare_to_html(str) {
  var map = {
    '&': '&amp;',
    '  ': '&nbsp;&nbsp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;',
    "‘": '&lsquo;',
    "’": '&rsquo;',
    "“": '&ldquo;',
    "”": '&rdquo;',
    "\t": '&#09;',
    "\v": '&#11;',
    "\r\n": '<br>',
    "\r": '<br>',
    "\n": '<br>'
  };
  return str.replace(/&|  |<|>|"|'|‘|’|“|”|\t|\v|\r\n|\r|\n/g, function (m) {
    return map[m];
  });
}

// кодирует в строке нижеуказанные символы во избежание некоторых трабл потом
function str_escape_encode(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };
  return text.replace(/[&<>"']/g, function (m) {
    return map[m];
  });
}

// декодирует в строке нижеуказанные символы / ЭТА ФУНКЦИЯ НЕ ПРОВЕРЯЛАСЬ В РАБОТЕ
function str_escape_decode(str) {
  var map = {
    '&amp;': '&',
    '&lt;': '<',
    '&gt;': '>',
    '&quot;': '"',
    '&#039;': "'"
  };
  return str.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g, function (m) {
    return map[m];
  });
}

// делает паузу в выполнении скрипта в любом месте
async function delay(ms) {
  await sleep(ms);

  function sleep(ms) {
    var date = new Date();
    var curDate = null;
    do {
      curDate = new Date();
    } while (curDate - date < ms);
  }
}

/* ▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀
 * FastClone JavaScript Library v1.0.0
 *
 применение:
 var Clone = FastClone.clone(object);
 где object - это объект или одномерный массив с любыми ячейками, хоть там числа хоть объекты
 */
var FastClone = {

  /* клонирует объект или одноуровневый массив с любыми ячейками, кроме вложенных массивов */
  clone: function (source, isDeep) {
    var deep = isDeep === undefined ? true : isDeep;

    if (Array.isArray(source)) {
      var clonedArray = [];
      if (source.length) {
        for (var i = 0; i < source.length; i++) {
          clonedArray.push(FastClone.clone_obg(source[i]));
        }
      }
      return clonedArray;
    }
    else {
      return FastClone.clone_obg(source);
    }
  },
  /**
   Вспомогательная функция.
   * This is a factory method that creates clone constructor function
   * for a specified object
   *
   * @param {Object} source - source object that need to be cloned next
   * @param {Boolean} isDeep - flag that represents should be clone deep or not (default: true)
   * @returns {Function}
   */
  factory: function (source, isDeep) {
    if (typeof source != 'object' || Array.isArray(source)) {
      throw new Error('Source is not an object');
    }
    var deep = isDeep === undefined ? true : isDeep;

    return new Function('src', FastClone._getKeyMap(source, deep));
  },

  /* Вспомогательная функция. Получает что угодно кроме массива и клонирует его, даже число или строку*/
  clone_obg: function (source) {
    if ((typeof source == "object") && (typeof source != null)) {
      var constru = FastClone.factory(source, true);
      var cloned_obg = new constru(source);
      return cloned_obg;
    }
    else {
      return source;
    }
  },

  /**
   Вспомогательная функция.
   * This method create map of object fields
   * for eval in clone function
   *
   * @param {Object|Array} source - source object that need to be cloned next
   * @param {Boolean} deep - flag that represents should be clone deep or not
   * @param {String} baseKey - current sequence of object keys
   * @param {Number} arrIndex - current sequence of array indexes
   * @returns {string}
   */
  _getKeyMap: function (source, deep, baseKey, arrIndex) {
    var base = baseKey || '';
    var index = (arrIndex || 0) + 1;

    var keysMap = base ? 'this' + base : '';

    if (Array.isArray(source)) {
      var iterVal = 'i' + index; // name of the current counter value
      var iterPath = base + '[' + iterVal + ']'; // path of the current array value

      if (typeof source[0] == 'object') {
        // This cycle will write code for copy array values
        keysMap += base ? ' = [];' : '';
        keysMap += 'for (var ' + iterVal + ' = 0; ' + iterVal + ' < src' + base + '.length; ' + iterVal + '++) {';
        keysMap += FastClone._getKeyMap(source[0], deep, iterPath, index);
        keysMap += '}';
      }
      else {
        keysMap += ' = src' + base + '.slice();';
      }
    }
    else {
      keysMap += base ? ' = {};' : '';

      // Iterate over object keys
      for (var key in source) {
        if (!source.hasOwnProperty(key)) {
          continue;
        }

        var value = source[key];
        var path = base + '.' + key; // current key path

        if (deep && typeof value == 'object' && value !== null) {
          keysMap += FastClone._getKeyMap(value, deep, path, index);
        }
        else {
          keysMap += 'this' + path + ' = src' + path + ';';
        }
      }
    }
    return keysMap;
  }
};
// ▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀

// делает у строки первую букву заглавной, остальный в нижнем регистре
function upper_first_letter(string) {
  return string[0].toLocaleUpperCase() + string.slice(1).toLocaleLowerCase();
}

/**
 считает реальную ширину строки с учетом шрифта
 Применение:
 textWidth("Text", "bold 13px Verdana")
 */
function textWidth(text, fontProp) {
  var tag = document.createElement("div");
  tag.style.position = "absolute";
  tag.style.left = "-999em";
  tag.style.whiteSpace = "nowrap";
  tag.style.font = fontProp;
  tag.innerHTML = text;

  document.body.appendChild(tag);

  var result = tag.clientWidth;

  document.body.removeChild(tag);

  return result;
}

/**
 считает реальную высоту строки с учетом шрифта
 Применение:
 textWidth("Text", "bold 13px Verdana")
 */
function textHeight(text, fontProp) {
  var tag = document.createElement("div");
  tag.style.position = "absolute";
  tag.style.left = "-999em";
  tag.style.whiteSpace = "nowrap";
  tag.style.font = fontProp;
  tag.innerHTML = text;

  document.body.appendChild(tag);

  var result = tag.clientHeight;

  document.body.removeChild(tag);

  return result;
}

/**
 для ускорения вывода в консоль
 */
function conlog(...param) {
  console.log(...param);
}

function clog(...param) {
  console.log(...param);
}

function cinfo(...param) {
  console.info(...param);
}

function cwarn(...param) {
  console.warn(...param);
}

function cerror(...param) {
  console.error(...param);
}

function cdir(...param) {
  console.dir(...param);
}

// Returns a random integer between minimum (included) and maximum (included)
function get_random_int(minimum, maximum) {
  var min, max;
  if (undef(minimum) && undef(maximum)) {
    min = 0;
    max = 100;
  }
  else if (undef(maximum)) {
    min = (minimum > 0) ? 0 : minimum;
    max = (min == 0) ? minimum : 0;
  }
  else if (minimum == maximum) {
    return minimum;
  }
  else if (minimum > maximum) {
    min = maximum;
    max = minimum;
  }
  else {
    min = minimum;
    max = maximum
  }
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

/*
 ___ Generates random string from latin letters or:
 String parameters:
 "rus" - include russian letters
 "lat" - include latin letters
 "dig" - include digits
 "sym" or "char" - include symbols   ~!@#$%^&*()_+|-{}№;:?,.[]

 Also first number parameter - minimum length of the tandom string,
 second number parameter - maximum length of the tandom string/
 Default minimum is 3, maximum is 10;
 Строчные параметры можно даже написать в одну строку-параметр слитно в любом порядке - пофиг
 */
function get_random_str(...args) {
  var _lat = _rus = _digits = _symbols = false;
  var letters_lat = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm";
  var letters_rus = "ЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮЁйцукенгшщзхъфывапролджэячсмитьбюё";
  var digits = "1234567890";
  var symbols = "~!@#$%^&*()_+|-{}№;:?,.[]";
  var letters = "";
  var min_length = max_length = undefined;

  for (let i = 0; i < args.length; i++) {
    switch (typeof args[i]) {
      case "string" :
        var param = args[i].toLowerCase();
        if (param.includes("rus")) _rus = true;
        if (param.includes("lat")) _lat = true;
        if (param.includes("dig")) _digits = true;
        if (param.includes("sym") || param.includes("char")) _symbols = true;
        break;
      case "number" :
        if (undef(min_length)) min_length = args[i]; else if (undef(max_length)) max_length = args[i];
        break;
    }
  }
  if (undef(min_length)) min_length = 3;
  if (undef(max_length)) max_length = 10;
  if (min_length > max_length) {
    let tmp = min_length;
    min_length = max_length;
    max_length = tmp;
  }
  if (_lat) letters += letters_lat;
  if (_rus) letters += letters_rus;
  if (_digits) letters += digits;
  if (_symbols) letters += symbols;
  if (letters == "") letters += letters_lat;

  var str = "";
  for (let i = 0; i < get_random_int(min_length, max_length); i++) {
    str += letters[get_random_int(0, letters.length - 1)];
  }
  return str;
}

/* функция для отладки, аналог эмметовской комбинации lorem***
 возвращает заданное количество случайных слов, правда сами слова являются просто наборами латинских букв.
 */
function get_random_text(words_number) {
  var text = get_random_str(3, 12);
  for (let i = 1; i < words_number; i++) {
    text += " " + get_random_str(3, 12);
  }
  return upper_first_letter(text);
}


// возращает строку, из которой удалены все пробельные символы, не только ' '
function remove_spaces(str) {
  if (undef(str)) return ""; else return str.replace(/\s+/g, '');
}

// скрывает объект HTML путём добавления класса d-none. Этот класс конечно же должен быть объявлен в стилях
function hide(id) {
  $(id).addClass("d-none");
}

// убирает класс d-none. Этот класс конечно же должен быть объявлен в стилях
function show(id) {
  $(id).removeClass("d-none");
}


// скрывает объект HTML путём добавления в свойство style "display: none"
function display_none(id) {
  $(id).css("display", "none");
}

// убирает из свойства style у тэга строку "display: none"
function display_none_off(id) {
  $(id).css("display", "");
}

// для отладки. Издаёт короткий звук
function bip() {
  var snd = new Audio("data:audio/wav;base64,//uQRAAAAWMSLwUIYAAsYkXgoQwAEaYLWfkWgAI0wWs/ItAAAGDgYtAgAyN+QWaAAihwMWm4G8QQRDiMcCBcH3Cc+CDv/7xA4Tvh9Rz/y8QADBwMWgQAZG/ILNAARQ4GLTcDeIIIhxGOBAuD7hOfBB3/94gcJ3w+o5/5eIAIAAAVwWgQAVQ2ORaIQwEMAJiDg95G4nQL7mQVWI6GwRcfsZAcsKkJvxgxEjzFUgfHoSQ9Qq7KNwqHwuB13MA4a1q/DmBrHgPcmjiGoh//EwC5nGPEmS4RcfkVKOhJf+WOgoxJclFz3kgn//dBA+ya1GhurNn8zb//9NNutNuhz31f////9vt///z+IdAEAAAK4LQIAKobHItEIYCGAExBwe8jcToF9zIKrEdDYIuP2MgOWFSE34wYiR5iqQPj0JIeoVdlG4VD4XA67mAcNa1fhzA1jwHuTRxDUQ//iYBczjHiTJcIuPyKlHQkv/LHQUYkuSi57yQT//uggfZNajQ3Vmz+Zt//+mm3Wm3Q576v////+32///5/EOgAAADVghQAAAAA//uQZAUAB1WI0PZugAAAAAoQwAAAEk3nRd2qAAAAACiDgAAAAAAABCqEEQRLCgwpBGMlJkIz8jKhGvj4k6jzRnqasNKIeoh5gI7BJaC1A1AoNBjJgbyApVS4IDlZgDU5WUAxEKDNmmALHzZp0Fkz1FMTmGFl1FMEyodIavcCAUHDWrKAIA4aa2oCgILEBupZgHvAhEBcZ6joQBxS76AgccrFlczBvKLC0QI2cBoCFvfTDAo7eoOQInqDPBtvrDEZBNYN5xwNwxQRfw8ZQ5wQVLvO8OYU+mHvFLlDh05Mdg7BT6YrRPpCBznMB2r//xKJjyyOh+cImr2/4doscwD6neZjuZR4AgAABYAAAABy1xcdQtxYBYYZdifkUDgzzXaXn98Z0oi9ILU5mBjFANmRwlVJ3/6jYDAmxaiDG3/6xjQQCCKkRb/6kg/wW+kSJ5//rLobkLSiKmqP/0ikJuDaSaSf/6JiLYLEYnW/+kXg1WRVJL/9EmQ1YZIsv/6Qzwy5qk7/+tEU0nkls3/zIUMPKNX/6yZLf+kFgAfgGyLFAUwY//uQZAUABcd5UiNPVXAAAApAAAAAE0VZQKw9ISAAACgAAAAAVQIygIElVrFkBS+Jhi+EAuu+lKAkYUEIsmEAEoMeDmCETMvfSHTGkF5RWH7kz/ESHWPAq/kcCRhqBtMdokPdM7vil7RG98A2sc7zO6ZvTdM7pmOUAZTnJW+NXxqmd41dqJ6mLTXxrPpnV8avaIf5SvL7pndPvPpndJR9Kuu8fePvuiuhorgWjp7Mf/PRjxcFCPDkW31srioCExivv9lcwKEaHsf/7ow2Fl1T/9RkXgEhYElAoCLFtMArxwivDJJ+bR1HTKJdlEoTELCIqgEwVGSQ+hIm0NbK8WXcTEI0UPoa2NbG4y2K00JEWbZavJXkYaqo9CRHS55FcZTjKEk3NKoCYUnSQ0rWxrZbFKbKIhOKPZe1cJKzZSaQrIyULHDZmV5K4xySsDRKWOruanGtjLJXFEmwaIbDLX0hIPBUQPVFVkQkDoUNfSoDgQGKPekoxeGzA4DUvnn4bxzcZrtJyipKfPNy5w+9lnXwgqsiyHNeSVpemw4bWb9psYeq//uQZBoABQt4yMVxYAIAAAkQoAAAHvYpL5m6AAgAACXDAAAAD59jblTirQe9upFsmZbpMudy7Lz1X1DYsxOOSWpfPqNX2WqktK0DMvuGwlbNj44TleLPQ+Gsfb+GOWOKJoIrWb3cIMeeON6lz2umTqMXV8Mj30yWPpjoSa9ujK8SyeJP5y5mOW1D6hvLepeveEAEDo0mgCRClOEgANv3B9a6fikgUSu/DmAMATrGx7nng5p5iimPNZsfQLYB2sDLIkzRKZOHGAaUyDcpFBSLG9MCQALgAIgQs2YunOszLSAyQYPVC2YdGGeHD2dTdJk1pAHGAWDjnkcLKFymS3RQZTInzySoBwMG0QueC3gMsCEYxUqlrcxK6k1LQQcsmyYeQPdC2YfuGPASCBkcVMQQqpVJshui1tkXQJQV0OXGAZMXSOEEBRirXbVRQW7ugq7IM7rPWSZyDlM3IuNEkxzCOJ0ny2ThNkyRai1b6ev//3dzNGzNb//4uAvHT5sURcZCFcuKLhOFs8mLAAEAt4UWAAIABAAAAAB4qbHo0tIjVkUU//uQZAwABfSFz3ZqQAAAAAngwAAAE1HjMp2qAAAAACZDgAAAD5UkTE1UgZEUExqYynN1qZvqIOREEFmBcJQkwdxiFtw0qEOkGYfRDifBui9MQg4QAHAqWtAWHoCxu1Yf4VfWLPIM2mHDFsbQEVGwyqQoQcwnfHeIkNt9YnkiaS1oizycqJrx4KOQjahZxWbcZgztj2c49nKmkId44S71j0c8eV9yDK6uPRzx5X18eDvjvQ6yKo9ZSS6l//8elePK/Lf//IInrOF/FvDoADYAGBMGb7FtErm5MXMlmPAJQVgWta7Zx2go+8xJ0UiCb8LHHdftWyLJE0QIAIsI+UbXu67dZMjmgDGCGl1H+vpF4NSDckSIkk7Vd+sxEhBQMRU8j/12UIRhzSaUdQ+rQU5kGeFxm+hb1oh6pWWmv3uvmReDl0UnvtapVaIzo1jZbf/pD6ElLqSX+rUmOQNpJFa/r+sa4e/pBlAABoAAAAA3CUgShLdGIxsY7AUABPRrgCABdDuQ5GC7DqPQCgbbJUAoRSUj+NIEig0YfyWUho1VBBBA//uQZB4ABZx5zfMakeAAAAmwAAAAF5F3P0w9GtAAACfAAAAAwLhMDmAYWMgVEG1U0FIGCBgXBXAtfMH10000EEEEEECUBYln03TTTdNBDZopopYvrTTdNa325mImNg3TTPV9q3pmY0xoO6bv3r00y+IDGid/9aaaZTGMuj9mpu9Mpio1dXrr5HERTZSmqU36A3CumzN/9Robv/Xx4v9ijkSRSNLQhAWumap82WRSBUqXStV/YcS+XVLnSS+WLDroqArFkMEsAS+eWmrUzrO0oEmE40RlMZ5+ODIkAyKAGUwZ3mVKmcamcJnMW26MRPgUw6j+LkhyHGVGYjSUUKNpuJUQoOIAyDvEyG8S5yfK6dhZc0Tx1KI/gviKL6qvvFs1+bWtaz58uUNnryq6kt5RzOCkPWlVqVX2a/EEBUdU1KrXLf40GoiiFXK///qpoiDXrOgqDR38JB0bw7SoL+ZB9o1RCkQjQ2CBYZKd/+VJxZRRZlqSkKiws0WFxUyCwsKiMy7hUVFhIaCrNQsKkTIsLivwKKigsj8XYlwt/WKi2N4d//uQRCSAAjURNIHpMZBGYiaQPSYyAAABLAAAAAAAACWAAAAApUF/Mg+0aohSIRobBAsMlO//Kk4soosy1JSFRYWaLC4qZBYWFRGZdwqKiwkNBVmoWFSJkWFxX4FFRQWR+LsS4W/rFRb/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////VEFHAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAU291bmRib3kuZGUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMjAwNGh0dHA6Ly93d3cuc291bmRib3kuZGUAAAAAAAAAACU=");
  snd.play();
}

/*
 получает объект JQuery и ищет его предки, соответствующие либо строке классов [второй параметр], либо классам и тэгу, которые передаются в виде объекта { classes: "card",tag: "div" }
 */
function find_parent_by_attr(JQuery_object, attr) {
  var parent = $(JQuery_object).parent();
  do {
    var attr_value = parent.attr(attr);
    if (attr_value != undefined) {
      return parent;
    }
    parent = parent.parent();
    // debugger
  } while (parent.length);
  return $();

  /*
   var set = $("*[" + attr + "]");
   for (let i = 0; i < set.length - 1; i++) {
   var child = set.eq(i).find(JQuery_object);
   if (child.length > 0)  return set.eq(i);
   }
   return $();
   */
}

// ищет у JQuery_object родителя, который в parent_classes_or_object
function find_parent(JQuery_object, parent_classes_or_object) {
  switch (typeof parent_classes_or_object) {
    case "string" :
      var parent = $(JQuery_object).parent();
      while (!parent.hasClass(parent_classes_or_object) && parent.length) {
        parent = $(parent).parent();
      }
      break;
    case "object" :
      var parent = $(JQuery_object).parent();
      while ((!parent.hasClass(parent_classes_or_object.classes) || !parent.is(parent_classes_or_object.tag)) && parent.length) {
        parent = $(parent).parent();
      }
      break;
    default:
      parent = $();
      break;
  }
  return parent;
}

// Returns сумму элементов массива, всех или из указанного диапазона
// В параметрах указывать НОМЕРА элементов массива, а не смещения
function get_array_elements_sum(elem1 = 1, elem2, arr) {
  var start_elem = elem1, end_elem;
  var len = arr.length;
  if (undef(elem2)) elem2 = arr.length; else elem2 = elem2

  if (elem1 < 1) elem1 = 1;
  if (elem2 < elem1) elem2 = elem1;
  var sum = 0;
  for (let i = elem1 - 1; i < elem2; i++) sum += arr[i];
  return sum;
}

/* ************************************************************************************
 в зависимости размера вьюпорта возвращает одно из 3х значений:
 "mobile" - для телефона или мелкого планшета
 "pad" - для планшета побольше
 "desktop" - для компьютера
 */
function getViewportSize() {
  styleStr = `@media only screen and (max-width: 575.98px) {
  viewport_detector {
    content: "mobile";
  }
}
@media only screen and (min-width: 576px) {
  viewport_detector {
    content: "tablet";
  }
}
@media only screen and (min-width: 800px) {
  viewport_detector {
    content: "desktop";
  }
}`;
  if (document.querySelector("viewport_detector") == null) {
    var body = document.querySelector("body");
    // body.innerHTML += '<viewport_detector></viewport_detector>';
    var tag = document.createElement('viewport_detector');
    document.body.appendChild(tag);
    appendStyleToTagHead(styleStr);
  }
  var result = getComputedStyle(document.querySelector("viewport_detector")).getPropertyValue('content')
  return result.slice(1, -1);

  function appendStyleToTagHead(content) {
    tag = document.createElement('style');
    tag.type = 'text/css';
    tag.appendChild(document.createTextNode(content));
    document.head.appendChild(tag);
  }
}

/*
 вернёт true, если это вьюпорт телефона/планшета вертикально
 */
function isMobileViewport() {
  return getViewportSize() == "mobile";
}
function isPadViewport() {
  return getViewportSize() == "tablet";
}
function isDesktopViewport() {
  return getViewportSize() == "desktop";
}

/*
добавляет ПАРАМЕТР в строку адреса http.
name=value
*/
function addParamInURL(name, value) {
  if (history.pushState) {
    var newURL = new URL(window.location);
    newURL.searchParams.set(name, value);
    history.pushState(null, null, newURL.href);
  } else {
    console.warn('History API is not supported by your browser');
  }
}

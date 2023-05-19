<template>
  <modal
    name="edit-lang-dialog"
    :width="824"
    height="auto"
    :scrollable="true"
    :adaptive="true"
    transition=""
    class="section-modal edit-lang-modal"
  >
    <div
      class="modal-close"
      @click="$modal.hide('edit-lang-dialog')"
    >
      <CloseIcon />
    </div>
    <div class="row">
      <h2 class="w700 poppins t-33" style="margin-bottom: 17px">Languages</h2>
      <div class="form-group">
        <h3 class="w700 t-28 poppins" style="margin-bottom: 10px">Add or edit languages</h3>
        <!-- <vue-tags-input
          class="tag-input"
          v-model="productFilterValue"
          :tags="userlanguage"
          :autocomplete-items="filteredProductItems"
          :add-only-from-autocomplete="true"
          placeholder="Add..."
          @tags-changed="updateVueProductsInput"
        /> -->

        <vue-tags-input
            class="tag-input"
            v-model="productFilterValue"
            :tags="userlanguage"
            :autocomplete-items="filteredProductItems"
            placeholder="Add..."
            @tags-changed="newTags => userlanguage = newTags"
          />
        <div class="btns">
          <button @click="updateLanguage" :disabled="submitting" class="btn btn-primary roboto">
            <div v-if="submitting" class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <span v-else>Submit</span>
          </button>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import VueTagsInput from "@johmun/vue-tags-input";
import CloseIcon from "../icons/CloseIcon.vue";

export default {
  name: "EditLanguagesModal",
  props: ["userlanguage"],
  components: {
    CloseIcon,
    VueTagsInput
  },
  data() {
    return {
      selectedTags: [],
      productFilterValue: "",
      submitting: false,
      autocompleteTagItems: [
        {
          "code": "ab",
          "text": "Abkhaz"
        },
        {
          "code": "aa",
          "text": "Afar"
        },
        {
          "code": "af",
          "text": "Afrikaans"
        },
        {
          "code": "ak",
          "text": "Akan"
        },
        {
          "code": "sq",
          "text": "Albanian"
        },
        {
          "code": "am",
          "text": "Amharic"
        },
        {
          "code": "ar",
          "text": "Arabic"
        },
        {
          "code": "an",
          "text": "Aragonese"
        },
        {
          "code": "hy",
          "text": "Armenian"
        },
        {
          "code": "as",
          "text": "Assamese"
        },
        {
          "code": "av",
          "text": "Avaric"
        },
        {
          "code": "ae",
          "text": "Avestan"
        },
        {
          "code": "ay",
          "text": "Aymara"
        },
        {
          "code": "az",
          "text": "Azerbaijani"
        },
        {
          "code": "bm",
          "text": "Bambara"
        },
        {
          "code": "ba",
          "text": "Bashkir"
        },
        {
          "code": "eu",
          "text": "Basque"
        },
        {
          "code": "be",
          "text": "Belarusian"
        },
        {
          "code": "bn",
          "text": "Bengali; Bangla"
        },
        {
          "code": "bh",
          "text": "Bihari"
        },
        {
          "code": "bi",
          "text": "Bislama"
        },
        {
          "code": "bs",
          "text": "Bosnian"
        },
        {
          "code": "br",
          "text": "Breton"
        },
        {
          "code": "bg",
          "text": "Bulgarian"
        },
        {
          "code": "my",
          "text": "Burmese"
        },
        {
          "code": "ca",
          "text": "Catalan; Valencian"
        },
        {
          "code": "ch",
          "text": "Chamorro"
        },
        {
          "code": "ce",
          "text": "Chechen"
        },
        {
          "code": "ny",
          "text": "Chichewa; Chewa; Nyanja"
        },
        {
          "code": "zh",
          "text": "Chinese"
        },
        {
          "code": "cv",
          "text": "Chuvash"
        },
        {
          "code": "kw",
          "text": "Cornish"
        },
        {
          "code": "co",
          "text": "Corsican"
        },
        {
          "code": "cr",
          "text": "Cree"
        },
        {
          "code": "hr",
          "text": "Croatian"
        },
        {
          "code": "cs",
          "text": "Czech"
        },
        {
          "code": "da",
          "text": "Danish"
        },
        {
          "code": "dv",
          "text": "Divehi; Dhivehi; Maldivian;"
        },
        {
          "code": "nl",
          "text": "Dutch"
        },
        {
          "code": "dz",
          "text": "Dzongkha"
        },
        {
          "code": "en",
          "text": "English"
        },
        {
          "code": "eo",
          "text": "Esperanto"
        },
        {
          "code": "et",
          "text": "Estonian"
        },
        {
          "code": "ee",
          "text": "Ewe"
        },
        {
          "code": "fo",
          "text": "Faroese"
        },
        {
          "code": "fj",
          "text": "Fijian"
        },
        {
          "code": "fi",
          "text": "Finnish"
        },
        {
          "code": "fr",
          "text": "French"
        },
        {
          "code": "ff",
          "text": "Fula; Fulah; Pulaar; Pular"
        },
        {
          "code": "gl",
          "text": "Galician"
        },
        {
          "code": "ka",
          "text": "Georgian"
        },
        {
          "code": "de",
          "text": "German"
        },
        {
          "code": "el",
          "text": "Greek, Modern"
        },
        {
          "code": "gn",
          "text": "GuaranÃ­"
        },
        {
          "code": "gu",
          "text": "Gujarati"
        },
        {
          "code": "ht",
          "text": "Haitian; Haitian Creole"
        },
        {
          "code": "ha",
          "text": "Hausa"
        },
        {
          "code": "he",
          "text": "Hebrew (modern)"
        },
        {
          "code": "hz",
          "text": "Herero"
        },
        {
          "code": "hi",
          "text": "Hindi"
        },
        {
          "code": "ho",
          "text": "Hiri Motu"
        },
        {
          "code": "hu",
          "text": "Hungarian"
        },
        {
          "code": "ia",
          "text": "Interlingua"
        },
        {
          "code": "id",
          "text": "Indonesian"
        },
        {
          "code": "ie",
          "text": "Interlingue"
        },
        {
          "code": "ga",
          "text": "Irish"
        },
        {
          "code": "ig",
          "text": "Igbo"
        },
        {
          "code": "ik",
          "text": "Inupiaq"
        },
        {
          "code": "io",
          "text": "Ido"
        },
        {
          "code": "is",
          "text": "Icelandic"
        },
        {
          "code": "it",
          "text": "Italian"
        },
        {
          "code": "iu",
          "text": "Inuktitut"
        },
        {
          "code": "ja",
          "text": "Japanese"
        },
        {
          "code": "jv",
          "text": "Javanese"
        },
        {
          "code": "kl",
          "text": "Kalaallisut, Greenlandic"
        },
        {
          "code": "kn",
          "text": "Kannada"
        },
        {
          "code": "kr",
          "text": "Kanuri"
        },
        {
          "code": "ks",
          "text": "Kashmiri"
        },
        {
          "code": "kk",
          "text": "Kazakh"
        },
        {
          "code": "km",
          "text": "Khmer"
        },
        {
          "code": "ki",
          "text": "Kikuyu, Gikuyu"
        },
        {
          "code": "rw",
          "text": "Kinyarwanda"
        },
        {
          "code": "ky",
          "text": "Kyrgyz"
        },
        {
          "code": "kv",
          "text": "Komi"
        },
        {
          "code": "kg",
          "text": "Kongo"
        },
        {
          "code": "ko",
          "text": "Korean"
        },
        {
          "code": "ku",
          "text": "Kurdish"
        },
        {
          "code": "kj",
          "text": "Kwanyama, Kuanyama"
        },
        {
          "code": "la",
          "text": "Latin"
        },
        {
          "code": "lb",
          "text": "Luxembourgish, Letzeburgesch"
        },
        {
          "code": "lg",
          "text": "Ganda"
        },
        {
          "code": "li",
          "text": "Limburgish, Limburgan, Limburger"
        },
        {
          "code": "ln",
          "text": "Lingala"
        },
        {
          "code": "lo",
          "text": "Lao"
        },
        {
          "code": "lt",
          "text": "Lithuanian"
        },
        {
          "code": "lu",
          "text": "Luba-Katanga"
        },
        {
          "code": "lv",
          "text": "Latvian"
        },
        {
          "code": "gv",
          "text": "Manx"
        },
        {
          "code": "mk",
          "text": "Macedonian"
        },
        {
          "code": "mg",
          "text": "Malagasy"
        },
        {
          "code": "ms",
          "text": "Malay"
        },
        {
          "code": "ml",
          "text": "Malayalam"
        },
        {
          "code": "mt",
          "text": "Maltese"
        },
        {
          "code": "mi",
          "text": "MÄori"
        },
        {
          "code": "mr",
          "text": "Marathi (MarÄá¹­hÄ«)"
        },
        {
          "code": "mh",
          "text": "Marshallese"
        },
        {
          "code": "mn",
          "text": "Mongolian"
        },
        {
          "code": "na",
          "text": "Nauru"
        },
        {
          "code": "nv",
          "text": "Navajo, Navaho"
        },
        {
          "code": "nb",
          "text": "Norwegian BokmÃ¥l"
        },
        {
          "code": "nd",
          "text": "North Ndebele"
        },
        {
          "code": "ne",
          "text": "Nepali"
        },
        {
          "code": "ng",
          "text": "Ndonga"
        },
        {
          "code": "nn",
          "text": "Norwegian Nynorsk"
        },
        {
          "code": "no",
          "text": "Norwegian"
        },
        {
          "code": "ii",
          "text": "Nuosu"
        },
        {
          "code": "nr",
          "text": "South Ndebele"
        },
        {
          "code": "oc",
          "text": "Occitan"
        },
        {
          "code": "oj",
          "text": "Ojibwe, Ojibwa"
        },
        {
          "code": "cu",
          "text": "Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic"
        },
        {
          "code": "om",
          "text": "Oromo"
        },
        {
          "code": "or",
          "text": "Oriya"
        },
        {
          "code": "os",
          "text": "Ossetian, Ossetic"
        },
        {
          "code": "pa",
          "text": "Panjabi, Punjabi"
        },
        {
          "code": "pi",
          "text": "PÄli"
        },
        {
          "code": "fa",
          "text": "Persian (Farsi)"
        },
        {
          "code": "pl",
          "text": "Polish"
        },
        {
          "code": "ps",
          "text": "Pashto, Pushto"
        },
        {
          "code": "pt",
          "text": "Portuguese"
        },
        {
          "code": "qu",
          "text": "Quechua"
        },
        {
          "code": "rm",
          "text": "Romansh"
        },
        {
          "code": "rn",
          "text": "Kirundi"
        },
        {
          "code": "ro",
          "text": "Romanian, [])"
        },
        {
          "code": "ru",
          "text": "Russian"
        },
        {
          "code": "sa",
          "text": "Sanskrit (Saá¹ská¹›ta)"
        },
        {
          "code": "sc",
          "text": "Sardinian"
        },
        {
          "code": "sd",
          "text": "Sindhi"
        },
        {
          "code": "se",
          "text": "Northern Sami"
        },
        {
          "code": "sm",
          "text": "Samoan"
        },
        {
          "code": "sg",
          "text": "Sango"
        },
        {
          "code": "sr",
          "text": "Serbian"
        },
        {
          "code": "gd",
          "text": "Scottish Gaelic; Gaelic"
        },
        {
          "code": "sn",
          "text": "Shona"
        },
        {
          "code": "si",
          "text": "Sinhala, Sinhalese"
        },
        {
          "code": "sk",
          "text": "Slovak"
        },
        {
          "code": "sl",
          "text": "Slovene"
        },
        {
          "code": "so",
          "text": "Somali"
        },
        {
          "code": "st",
          "text": "Southern Sotho"
        },
        {
          "code": "es",
          "text": "Spanish; Castilian"
        },
        {
          "code": "su",
          "text": "Sundanese"
        },
        {
          "code": "sw",
          "text": "Swahili"
        },
        {
          "code": "ss",
          "text": "Swati"
        },
        {
          "code": "sv",
          "text": "Swedish"
        },
        {
          "code": "ta",
          "text": "Tamil"
        },
        {
          "code": "te",
          "text": "Telugu"
        },
        {
          "code": "tg",
          "text": "Tajik"
        },
        {
          "code": "th",
          "text": "Thai"
        },
        {
          "code": "ti",
          "text": "Tigrinya"
        },
        {
          "code": "bo",
          "text": "Tibetan Standard, Tibetan, Central"
        },
        {
          "code": "tk",
          "text": "Turkmen"
        },
        {
          "code": "tl",
          "text": "Tagalog"
        },
        {
          "code": "tn",
          "text": "Tswana"
        },
        {
          "code": "to",
          "text": "Tonga (Tonga Islands)"
        },
        {
          "code": "tr",
          "text": "Turkish"
        },
        {
          "code": "ts",
          "text": "Tsonga"
        },
        {
          "code": "tt",
          "text": "Tatar"
        },
        {
          "code": "tw",
          "text": "Twi"
        },
        {
          "code": "ty",
          "text": "Tahitian"
        },
        {
          "code": "ug",
          "text": "Uyghur, Uighur"
        },
        {
          "code": "uk",
          "text": "Ukrainian"
        },
        {
          "code": "ur",
          "text": "Urdu"
        },
        {
          "code": "uz",
          "text": "Uzbek"
        },
        {
          "code": "ve",
          "text": "Venda"
        },
        {
          "code": "vi",
          "text": "Viettextse"
        },
        {
          "code": "vo",
          "text": "VolapÃ¼k"
        },
        {
          "code": "wa",
          "text": "Walloon"
        },
        {
          "code": "cy",
          "text": "Welsh"
        },
        {
          "code": "wo",
          "text": "Wolof"
        },
        {
          "code": "fy",
          "text": "Western Frisian"
        },
        {
          "code": "xh",
          "text": "Xhosa"
        },
        {
          "code": "yi",
          "text": "Yiddish"
        },
        {
          "code": "yo",
          "text": "Yoruba"
        },
        {
          "code": "za",
          "text": "Zhuang, Chuang"
        },
        {
          "code": "zu",
          "text": "Zulu"
        }
      ],
      autocompleteProductItems: [
        {
          "code": "ab",
          "text": "Abkhaz"
        },
        {
          "code": "aa",
          "text": "Afar"
        },
        {
          "code": "af",
          "text": "Afrikaans"
        },
        {
          "code": "ak",
          "text": "Akan"
        },
        {
          "code": "sq",
          "text": "Albanian"
        },
        {
          "code": "am",
          "text": "Amharic"
        },
        {
          "code": "ar",
          "text": "Arabic"
        },
        {
          "code": "an",
          "text": "Aragonese"
        },
        {
          "code": "hy",
          "text": "Armenian"
        },
        {
          "code": "as",
          "text": "Assamese"
        },
        {
          "code": "av",
          "text": "Avaric"
        },
        {
          "code": "ae",
          "text": "Avestan"
        },
        {
          "code": "ay",
          "text": "Aymara"
        },
        {
          "code": "az",
          "text": "Azerbaijani"
        },
        {
          "code": "bm",
          "text": "Bambara"
        },
        {
          "code": "ba",
          "text": "Bashkir"
        },
        {
          "code": "eu",
          "text": "Basque"
        },
        {
          "code": "be",
          "text": "Belarusian"
        },
        {
          "code": "bn",
          "text": "Bengali; Bangla"
        },
        {
          "code": "bh",
          "text": "Bihari"
        },
        {
          "code": "bi",
          "text": "Bislama"
        },
        {
          "code": "bs",
          "text": "Bosnian"
        },
        {
          "code": "br",
          "text": "Breton"
        },
        {
          "code": "bg",
          "text": "Bulgarian"
        },
        {
          "code": "my",
          "text": "Burmese"
        },
        {
          "code": "ca",
          "text": "Catalan; Valencian"
        },
        {
          "code": "ch",
          "text": "Chamorro"
        },
        {
          "code": "ce",
          "text": "Chechen"
        },
        {
          "code": "ny",
          "text": "Chichewa; Chewa; Nyanja"
        },
        {
          "code": "zh",
          "text": "Chinese"
        },
        {
          "code": "cv",
          "text": "Chuvash"
        },
        {
          "code": "kw",
          "text": "Cornish"
        },
        {
          "code": "co",
          "text": "Corsican"
        },
        {
          "code": "cr",
          "text": "Cree"
        },
        {
          "code": "hr",
          "text": "Croatian"
        },
        {
          "code": "cs",
          "text": "Czech"
        },
        {
          "code": "da",
          "text": "Danish"
        },
        {
          "code": "dv",
          "text": "Divehi; Dhivehi; Maldivian;"
        },
        {
          "code": "nl",
          "text": "Dutch"
        },
        {
          "code": "dz",
          "text": "Dzongkha"
        },
        {
          "code": "en",
          "text": "English"
        },
        {
          "code": "eo",
          "text": "Esperanto"
        },
        {
          "code": "et",
          "text": "Estonian"
        },
        {
          "code": "ee",
          "text": "Ewe"
        },
        {
          "code": "fo",
          "text": "Faroese"
        },
        {
          "code": "fj",
          "text": "Fijian"
        },
        {
          "code": "fi",
          "text": "Finnish"
        },
        {
          "code": "fr",
          "text": "French"
        },
        {
          "code": "ff",
          "text": "Fula; Fulah; Pulaar; Pular"
        },
        {
          "code": "gl",
          "text": "Galician"
        },
        {
          "code": "ka",
          "text": "Georgian"
        },
        {
          "code": "de",
          "text": "German"
        },
        {
          "code": "el",
          "text": "Greek, Modern"
        },
        {
          "code": "gn",
          "text": "GuaranÃ­"
        },
        {
          "code": "gu",
          "text": "Gujarati"
        },
        {
          "code": "ht",
          "text": "Haitian; Haitian Creole"
        },
        {
          "code": "ha",
          "text": "Hausa"
        },
        {
          "code": "he",
          "text": "Hebrew (modern)"
        },
        {
          "code": "hz",
          "text": "Herero"
        },
        {
          "code": "hi",
          "text": "Hindi"
        },
        {
          "code": "ho",
          "text": "Hiri Motu"
        },
        {
          "code": "hu",
          "text": "Hungarian"
        },
        {
          "code": "ia",
          "text": "Interlingua"
        },
        {
          "code": "id",
          "text": "Indonesian"
        },
        {
          "code": "ie",
          "text": "Interlingue"
        },
        {
          "code": "ga",
          "text": "Irish"
        },
        {
          "code": "ig",
          "text": "Igbo"
        },
        {
          "code": "ik",
          "text": "Inupiaq"
        },
        {
          "code": "io",
          "text": "Ido"
        },
        {
          "code": "is",
          "text": "Icelandic"
        },
        {
          "code": "it",
          "text": "Italian"
        },
        {
          "code": "iu",
          "text": "Inuktitut"
        },
        {
          "code": "ja",
          "text": "Japanese"
        },
        {
          "code": "jv",
          "text": "Javanese"
        },
        {
          "code": "kl",
          "text": "Kalaallisut, Greenlandic"
        },
        {
          "code": "kn",
          "text": "Kannada"
        },
        {
          "code": "kr",
          "text": "Kanuri"
        },
        {
          "code": "ks",
          "text": "Kashmiri"
        },
        {
          "code": "kk",
          "text": "Kazakh"
        },
        {
          "code": "km",
          "text": "Khmer"
        },
        {
          "code": "ki",
          "text": "Kikuyu, Gikuyu"
        },
        {
          "code": "rw",
          "text": "Kinyarwanda"
        },
        {
          "code": "ky",
          "text": "Kyrgyz"
        },
        {
          "code": "kv",
          "text": "Komi"
        },
        {
          "code": "kg",
          "text": "Kongo"
        },
        {
          "code": "ko",
          "text": "Korean"
        },
        {
          "code": "ku",
          "text": "Kurdish"
        },
        {
          "code": "kj",
          "text": "Kwanyama, Kuanyama"
        },
        {
          "code": "la",
          "text": "Latin"
        },
        {
          "code": "lb",
          "text": "Luxembourgish, Letzeburgesch"
        },
        {
          "code": "lg",
          "text": "Ganda"
        },
        {
          "code": "li",
          "text": "Limburgish, Limburgan, Limburger"
        },
        {
          "code": "ln",
          "text": "Lingala"
        },
        {
          "code": "lo",
          "text": "Lao"
        },
        {
          "code": "lt",
          "text": "Lithuanian"
        },
        {
          "code": "lu",
          "text": "Luba-Katanga"
        },
        {
          "code": "lv",
          "text": "Latvian"
        },
        {
          "code": "gv",
          "text": "Manx"
        },
        {
          "code": "mk",
          "text": "Macedonian"
        },
        {
          "code": "mg",
          "text": "Malagasy"
        },
        {
          "code": "ms",
          "text": "Malay"
        },
        {
          "code": "ml",
          "text": "Malayalam"
        },
        {
          "code": "mt",
          "text": "Maltese"
        },
        {
          "code": "mi",
          "text": "MÄori"
        },
        {
          "code": "mr",
          "text": "Marathi (MarÄá¹­hÄ«)"
        },
        {
          "code": "mh",
          "text": "Marshallese"
        },
        {
          "code": "mn",
          "text": "Mongolian"
        },
        {
          "code": "na",
          "text": "Nauru"
        },
        {
          "code": "nv",
          "text": "Navajo, Navaho"
        },
        {
          "code": "nb",
          "text": "Norwegian BokmÃ¥l"
        },
        {
          "code": "nd",
          "text": "North Ndebele"
        },
        {
          "code": "ne",
          "text": "Nepali"
        },
        {
          "code": "ng",
          "text": "Ndonga"
        },
        {
          "code": "nn",
          "text": "Norwegian Nynorsk"
        },
        {
          "code": "no",
          "text": "Norwegian"
        },
        {
          "code": "ii",
          "text": "Nuosu"
        },
        {
          "code": "nr",
          "text": "South Ndebele"
        },
        {
          "code": "oc",
          "text": "Occitan"
        },
        {
          "code": "oj",
          "text": "Ojibwe, Ojibwa"
        },
        {
          "code": "cu",
          "text": "Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic"
        },
        {
          "code": "om",
          "text": "Oromo"
        },
        {
          "code": "or",
          "text": "Oriya"
        },
        {
          "code": "os",
          "text": "Ossetian, Ossetic"
        },
        {
          "code": "pa",
          "text": "Panjabi, Punjabi"
        },
        {
          "code": "pi",
          "text": "PÄli"
        },
        {
          "code": "fa",
          "text": "Persian (Farsi)"
        },
        {
          "code": "pl",
          "text": "Polish"
        },
        {
          "code": "ps",
          "text": "Pashto, Pushto"
        },
        {
          "code": "pt",
          "text": "Portuguese"
        },
        {
          "code": "qu",
          "text": "Quechua"
        },
        {
          "code": "rm",
          "text": "Romansh"
        },
        {
          "code": "rn",
          "text": "Kirundi"
        },
        {
          "code": "ro",
          "text": "Romanian, [])"
        },
        {
          "code": "ru",
          "text": "Russian"
        },
        {
          "code": "sa",
          "text": "Sanskrit (Saá¹ská¹›ta)"
        },
        {
          "code": "sc",
          "text": "Sardinian"
        },
        {
          "code": "sd",
          "text": "Sindhi"
        },
        {
          "code": "se",
          "text": "Northern Sami"
        },
        {
          "code": "sm",
          "text": "Samoan"
        },
        {
          "code": "sg",
          "text": "Sango"
        },
        {
          "code": "sr",
          "text": "Serbian"
        },
        {
          "code": "gd",
          "text": "Scottish Gaelic; Gaelic"
        },
        {
          "code": "sn",
          "text": "Shona"
        },
        {
          "code": "si",
          "text": "Sinhala, Sinhalese"
        },
        {
          "code": "sk",
          "text": "Slovak"
        },
        {
          "code": "sl",
          "text": "Slovene"
        },
        {
          "code": "so",
          "text": "Somali"
        },
        {
          "code": "st",
          "text": "Southern Sotho"
        },
        {
          "code": "es",
          "text": "Spanish; Castilian"
        },
        {
          "code": "su",
          "text": "Sundanese"
        },
        {
          "code": "sw",
          "text": "Swahili"
        },
        {
          "code": "ss",
          "text": "Swati"
        },
        {
          "code": "sv",
          "text": "Swedish"
        },
        {
          "code": "ta",
          "text": "Tamil"
        },
        {
          "code": "te",
          "text": "Telugu"
        },
        {
          "code": "tg",
          "text": "Tajik"
        },
        {
          "code": "th",
          "text": "Thai"
        },
        {
          "code": "ti",
          "text": "Tigrinya"
        },
        {
          "code": "bo",
          "text": "Tibetan Standard, Tibetan, Central"
        },
        {
          "code": "tk",
          "text": "Turkmen"
        },
        {
          "code": "tl",
          "text": "Tagalog"
        },
        {
          "code": "tn",
          "text": "Tswana"
        },
        {
          "code": "to",
          "text": "Tonga (Tonga Islands)"
        },
        {
          "code": "tr",
          "text": "Turkish"
        },
        {
          "code": "ts",
          "text": "Tsonga"
        },
        {
          "code": "tt",
          "text": "Tatar"
        },
        {
          "code": "tw",
          "text": "Twi"
        },
        {
          "code": "ty",
          "text": "Tahitian"
        },
        {
          "code": "ug",
          "text": "Uyghur, Uighur"
        },
        {
          "code": "uk",
          "text": "Ukrainian"
        },
        {
          "code": "ur",
          "text": "Urdu"
        },
        {
          "code": "uz",
          "text": "Uzbek"
        },
        {
          "code": "ve",
          "text": "Venda"
        },
        {
          "code": "vi",
          "text": "Viettextse"
        },
        {
          "code": "vo",
          "text": "VolapÃ¼k"
        },
        {
          "code": "wa",
          "text": "Walloon"
        },
        {
          "code": "cy",
          "text": "Welsh"
        },
        {
          "code": "wo",
          "text": "Wolof"
        },
        {
          "code": "fy",
          "text": "Western Frisian"
        },
        {
          "code": "xh",
          "text": "Xhosa"
        },
        {
          "code": "yi",
          "text": "Yiddish"
        },
        {
          "code": "yo",
          "text": "Yoruba"
        },
        {
          "code": "za",
          "text": "Zhuang, Chuang"
        },
        {
          "code": "zu",
          "text": "Zulu"
        }
      ]
    };
  },
  methods: {
    async updateLanguage() {
      if (this.userlanguage.length <= 0) {
        this.$toast.error("Language is required!");
        return;
      }

      this.submitting = true;

      const result = await this.callApi(
        "post",
        window.api_path + "profile/updateProfilelanguage",
        {
          user_id: localStorage.logged_user_id,
          languages: this.userlanguage
        }
      );
      if (result.data.code !== 1) {
        this.$toast.error(result.data.message);
        return;
      }
      this.newCommunityText = "";
      this.$toast.success(result.data.data);
      this.$modal.hide("edit-lang-dialog");
      this.submitting = false;
      this.$emit("update-language");
    },
    updateVueTagsInput(newTags) {
      this.selectedTags = newTags;
    },
    updateVueProductsInput(newProducts) {
      this.userlanguage = newProducts;
    }
  },
  computed: {
    filteredProductItems() {
      return this.autocompleteProductItems.filter(i => {
        return (
          i.text
            .toLowerCase()
            .indexOf(this.productFilterValue.toLowerCase()) !== -1
        );
      });
    },

    filteredTagItems() {
      return this.autocompleteTagItems.filter(i => {
        return (
          i.text.toLowerCase().indexOf(this.tagFilterValue.toLowerCase()) !== -1
        );
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.modal-close {
  padding: 0 !important;
  top: 31px !important;
  right: 31px !important;
}

.row {
  margin: 10px 20px 0px 20px;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;

  .btns {
    width: 100%;
    display: flex;
    justify-content: center;
    margin-top: 30px;

    .btn {
      margin: 0 !important;
      height: 83.34px;
      width: 284.25px;
      background: #F2A91C;
      border-radius: 15px;
      font-size: 24px;
      border: none;
      color: #000000;
      font-weight: 500;
    }
  }

  h2 {
    width: 100%;
    text-align: center;
    line-height: 54px;
  }

  .form-group {
    width: 100%;

    textarea {
      background: #E6E6E6;
      border-radius: 5px;
      height: 194px;
      font-size: 24px;
      line-height: 28px;

      &::placeholder {
        color: #333333;
      }
    }
  }
}
</style>

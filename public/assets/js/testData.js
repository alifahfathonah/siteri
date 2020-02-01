var testData = {};
// JSON string, could get this from anywhere
        testData.countryCodes = '[
        {"id":"01","text":"Kabupaten Aceh Barat"},
        {"id":"02", "text":"Kabupaten Aceh Barat Daya"},
        {"id":"03", "text":"Kabupaten Aceh Besar"},
        {"id":"04", "text":"Kabupaten Aceh Jaya"},
        {"id":"05", "text":"Kabupaten Aceh Selatan"},
        {"id":"06", "text":"Kabupaten Aceh Singkil"},
        {"id":"07", "text":"Kabupaten Aceh Tamiang"},
        {"id":"08", "text":"Kabupaten Aceh Tengah"},
        {"id":"09", "text":"Kabupaten Aceh Tenggara"},
        {"id":"10", "text":"Kabupaten Aceh Timur"},
        {"id":"11", "text":"Kabupaten Aceh Utara"},
        {"id":"12", "text":"Kabupaten Agam"},
        {"id":"13", "text":"Kabupaten Alor"},
        {"id":"14", "text":"Kabupaten Asahan"},
        {"id":"15", "text":"Kabupaten Asmat"},
        {"id":"16", "text":"Kabupaten Badung"},
        {"id":"17", "text":"Kabupaten Balangan"},
        {"id":"18", "text":"Kabupaten Bandung"},
        {"id":"19", "text":"Kabupaten Bandung Barat"},
        {"id":"20", "text":"Kabupaten Banggai"},
        {"id":"21", "text":"Kabupaten Banggai Kepulauan"},
        {"id":"22", "text":"Kabupaten Banggai Laut"},
        {"id":"23", "text":"Kabupaten Bangka"},
        {"id":"24", "text":"Kabupaten Bangka Barat"},
        {"id":"25", "text":"Kabupaten Bangka Selatan"},
        {"id":"26", "text":"Kabupaten Bangka Tengah"},
        {"id":"27", "text":"Kabupaten Bangkalan"},
        {"id":"28", "text":"Kabupaten Bangli"},
        {"id":"29", "text":"Kabupaten Banjar"},
        {"id":"30", "text":"Kabupaten Banjarnegara"},
        {"id":"31", "text":"Kabupaten Bantaeng"},
        {"id":"32", "text":"Kabupaten Bantul"},
        {"id":"33", "text":"Kabupaten Banyuasin"},
        {"id":"34", "text":"Kabupaten Banyumas"},
        {"id":"35", "text":"Kabupaten Banyuwangi"},
        {"id":"36", "text":"Kabupaten Barito Kuala"},
        {"id":"37", "text":"Kabupaten Barito Selatan"},
        {"id":"38", "text":"Kabupaten Barito Timur"},
        {"id":"39", "text":"Kabupaten Barito Utara"},
        {"id":"40", "text":"Kabupaten Barru"},
        {"id":"41", "text":"Kabupaten Batang"},
        {"id":"42", "text":"Kabupaten Batanghari"},
        {"id":"43", "text":"Kabupaten Batubara"},
        {"id":"44", "text":"Kabupaten Bekasi"},
        {"id":"45", "text":"Kabupaten Belitung"},
        {"id":"46", "text":"Kabupaten Belitung Timur"},
        {"id":"47", "text":"Kabupaten Belu"},
        {"id":"48", "text":"Kabupaten Bener Meriah"},
        {"id":"49", "text":"Kabupaten Bengkalis"},
        {"id":"50", "text":"Kabupaten Bengkayang"},
        {"id":"51", "text":"Kabupaten Bengkulu Selatan"},
        {"id":"52", "text":"Kabupaten Bengkulu Tengah"},
        {"id":"53", "text":"Kabupaten Bengkulu Utara"},
        {"id":"54", "text":"Kabupaten Berau"},
        {"id":"55", "text":"Kabupaten Biak Numfor"},
        {"id":"56", "text":"Kabupaten Bima"},
        {"id":"57", "text":"Kabupaten Bintan"},
        {"id":"58", "text":"Kabupaten Bireuen"},
        {"id":"59", "text":"Kabupaten Blitar"},
        {"id":"60", "text":"Kabupaten Blora"},
        {"id":"61", "text":"Kabupaten Boalemo"},
        {"id":"62", "text":"Kabupaten Bogor"},
        {"id":"63", "text":"Kabupaten Bojonegoro"},
        {"id":"64", "text":"Kabupaten Bolaang Mongondow"},
        {"id":"65", "text":"Kabupaten Bolaang Mongondow Selatan"},
        {"id":"66", "text":"Kabupaten Bolaang Mongondow Timur"},
        {"id":"67", "text":"Kabupaten Bolaang Mongondow Utara"},
        {"id":"68", "text":"Kabupaten Bombana"},
        {"id":"69", "text":"Kabupaten Bondowoso"},
        {"id":"70", "text":"Kabupaten Bone"},
        {"id":"71", "text":"Kabupaten Bone Bolango"},
        {"id":"72", "text":"Kabupaten Boven Digoel"},
        {"id":"73", "text":"Kabupaten Boyolali"},
        {"id":"74", "text":"Kabupaten Brebes"},
        {"id":"75", "text":"Kabupaten Buleleng"},
        {"id":"76", "text":"Kabupaten Bulukumba"},
        {"id":"77", "text":"Kabupaten Bulungan"},
        {"id":"78", "text":"Kabupaten Bungo"},
        {"id":"79", "text":"Kabupaten Buol"},
        {"id":"80", "text":"Kabupaten Buru"},
        {"id":"81", "text":"Kabupaten Buru Selatan"},
        {"id":"82", "text":"Kabupaten Buton"},
        {"id":"83", "text":"Kabupaten Buton Selatan"},
        {"id":"84", "text":"Kabupaten Buton Tengah"},
        {"id":"85", "text":"Kabupaten Buton Utara"},
        {"id":"86", "text":"Kabupaten Ciamis"},
        {"id":"87", "text":"Kabupaten Cianjur"},
        {"id":"88", "text":"Kabupaten Cilacap"},
        {"id":"89", "text":"Kabupaten Cirebon"},
        {"id":"90", "text":"Kabupaten Dairi"},
        {"id":"91", "text":"Kabupaten Deiyai"},
        {"id":"92", "text":"Kabupaten Deli Serdang"},
        {"id":"93", "text":"Kabupaten Demak"},
        {"id":"94", "text":"Kabupaten Dharmasraya"},
        {"id":"95", "text":"Kabupaten Dogiyai"},
        {"id":"96", "text":"Kabupaten Dompu"},
        {"id":"97", "text":"Kabupaten Donggala"},
        {"id":"98", "text":"Kabupaten Empat Lawang"},
        {"id":"99", "text":"Kabupaten Ende"},
        {"id":"100", "text":"Kabupaten Enrekang"},
        {"id":"101", "text":"Kabupaten Fakfak"},
        {"id":"102", "text":"Kabupaten Flores Timur"},
        {"id":"103", "text":"Kabupaten Garut"},
        {"id":"104", "text":"Kabupaten Gayo Lues"},
        {"id":"105", "text":"Kabupaten Gianyar"},
        {"id":"106", "text":"Kabupaten Gorontalo"},
        {"id":"107", "text":"Kabupaten Gorontalo Utara"},
        {"id":"108", "text":"Kabupaten Gowa"},
        {"id":"109", "text":"Kabupaten Gresik"},
        {"id":"110", "text":"Kabupaten Grobogan"},
        {"id":"111", "text":"Kabupaten Gunung Mas"},
        {"id":"112", "text":"Kabupaten Gunungkidul"},
        {"id":"113", "text":"Kabupaten Halmahera Barat"},
        {"id":"114", "text":"Kabupaten Halmahera Selatan"},
        {"id":"115", "text":"Kabupaten Halmahera Tengah"},
        {"id":"116", "text":"Kabupaten Halmahera Timur"},
        {"id":"117", "text":"Kabupaten Halmahera Utara"},
        {"id":"118", "text":"Kabupaten Hulu Sungai Selatan"},
        {"id":"119", "text":"Kabupaten Hulu Sungai Tengah"},
        {"id":"120", "text":"Kabupaten Hulu Sungai Utara"},
        {"id":"121", "text":"Kabupaten Humbang Hasundutan"},
        {"id":"122", "text":"Kabupaten Indragiri Hilir"},
        {"id":"123", "text":"Kabupaten Indragiri Hulu"},
        {"id":"124", "text":"Kabupaten Indramayu"},
        {"id":"125", "text":"Kabupaten Intan Jaya"},
        {"id":"126", "text":"Kabupaten Jayapura"},
        {"id":"127", "text":"Kabupaten Jayawijaya"},
        {"id":"128", "text":"Kabupaten Jember"},
        {"id":"129", "text":"Kabupaten Jembrana"},
        {"id":"130", "text":"Kabupaten Jeneponto"},
        {"id":"131", "text":"Kabupaten Jepara"},
        {"id":"132", "text":"Kabupaten Jombang"},
        {"id":"133", "text":"Kabupaten Kaimana"},
        {"id":"134", "text":"Kabupaten Kampar"},
        {"id":"135", "text":"Kabupaten Kapuas"},
        {"id":"136", "text":"Kabupaten Kapuas Hulu"},
        {"id":"137", "text":"Kabupaten Karanganyar"},
        {"id":"138", "text":"Kabupaten Karangasem"},
        {"id":"139", "text":"Kabupaten Karawang"},
        {"id":"140", "text":"Kabupaten Karimun"},
        {"id":"141", "text":"Kabupaten Karo"},
        {"id":"142", "text":"Kabupaten Katingan"},
        {"id":"143", "text":"Kabupaten Kaur"},
        {"id":"144", "text":"Kabupaten Kayong Utara"},
        {"id":"145", "text":"Kabupaten Kebumen"},
        {"id":"146", "text":"Kabupaten Kediri"},
        {"id":"147", "text":"Kabupaten Keerom"},
        {"id":"148", "text":"Kabupaten Kendal"},
        {"id":"149", "text":"Kabupaten Kepahiang"},
        {"id":"150", "text":"Kabupaten Kepulauan Anambas"},
        {"id":"151", "text":"Kabupaten Kepulauan Aru"},
        {"id":"152", "text":"Kabupaten Kepulauan Mentawai"},
        {"id":"153", "text":"Kabupaten Kepulauan Meranti"},
        {"id":"154", "text":"Kabupaten Kepulauan Sangihe"},
        {"id":"155", "text":"Kabupaten Kepulauan Selayar"},
        {"id":"156", "text":"Kabupaten Kepulauan Siau Tagulandang Biaro"},
        {"id":"157", "text":"Kabupaten Kepulauan Sula"},
        {"id":"158", "text":"Kabupaten Kepulauan Talaud"},
        {"id":"159", "text":"Kabupaten Kepulauan Yapen"},
        {"id":"160", "text":"Kabupaten Kerinci"},
        {"id":"161", "text":"Kabupaten Ketapang"},
        {"id":"162", "text":"Kabupaten Klaten"},
        {"id":"163", "text":"Kabupaten Klungkung"},
        {"id":"164", "text":"Kabupaten Kolaka"},
        {"id":"165", "text":"Kabupaten Kolaka Timur"},
        {"id":"166", "text":"Kabupaten Kolaka Utara"},
        {"id":"167", "text":"Kabupaten Konawe"},
        {"id":"168", "text":"Kabupaten Konawe Kepulauan"},
        {"id":"169", "text":"Kabupaten Konawe Selatan"},
        {"id":"170", "text":"Kabupaten Konawe Utara"},
        {"id":"171", "text":"Kabupaten Kotabaru"},
        {"id":"172", "text":"Kabupaten Kotawaringin Barat"},
        {"id":"173", "text":"Kabupaten Kotawaringin Timur"},
        {"id":"174", "text":"Kabupaten Kuantan Singingi"},
        {"id":"175", "text":"Kabupaten Kubu Raya"},
        {"id":"176", "text":"Kabupaten Kudus"},
        {"id":"177", "text":"Kabupaten Kulon Progo"},
        {"id":"178", "text":"Kabupaten Kuningan"},
        {"id":"179", "text":"Kabupaten Kupang"},
        {"id":"180", "text":"Kabupaten Kutai Barat"},
        {"id":"181", "text":"Kabupaten Kutai Kartanegara"},
        {"id":"182", "text":"Kabupaten Kutai Timur"},
        {"id":"183", "text":"Kabupaten Labuhanbatu"},
        {"id":"184", "text":"Kabupaten Labuhanbatu Selatan"},
        {"id":"185", "text":"Kabupaten Labuhanbatu Utara"},
        {"id":"186", "text":"Kabupaten Lahat"},
        {"id":"187", "text":"Kabupaten Lamandau"},
        {"id":"188", "text":"Kabupaten Lamongan"},
        {"id":"189", "text":"Kabupaten Lampung Barat"},
        {"id":"190", "text":"Kabupaten Lampung Selatan"},
        {"id":"191", "text":"Kabupaten Lampung Tengah"},
        {"id":"192", "text":"Kabupaten Lampung Timur"},
        {"id":"193", "text":"Kabupaten Lampung Utara"},
        {"id":"194", "text":"Kabupaten Landak"},
        {"id":"195", "text":"Kabupaten Langkat"},
        {"id":"196", "text":"Kabupaten Lanny Jaya"},
        {"id":"197", "text":"Kabupaten Lebak"},
        {"id":"198", "text":"Kabupaten Lebong"},
        {"id":"199", "text":"Kabupaten Lembata"},
        {"id":"200", "text":"Kabupaten Lima Puluh Kota"},
        {"id":"201", "text":"Kabupaten Lingga"},
        {"id":"202", "text":"Kabupaten Lombok Barat"},
        {"id":"203", "text":"Kabupaten Lombok Tengah"},
        {"id":"204", "text":"Kabupaten Lombok Timur"},
        {"id":"205", "text":"Kabupaten Lombok Utara"},
        {"id":"206", "text":"Kabupaten Lumajang"},
        {"id":"207", "text":"Kabupaten Luwu"},
        {"id":"208", "text":"Kabupaten Luwu Timur"},
        {"id":"209", "text":"Kabupaten Luwu Utara"},
        {"id":"210", "text":"Kabupaten Madiun"},
        {"id":"211", "text":"Kabupaten Magelang"},
        {"id":"212", "text":"Kabupaten Magetan"},
        {"id":"213", "text":"Kabupaten Mahakam Ulu"},
        {"id":"214", "text":"Kabupaten Majalengka"},
        {"id":"215", "text":"Kabupaten Majene"},
        {"id":"216", "text":"Kabupaten Malaka"},
        {"id":"217", "text":"Kabupaten Malang"},
        {"id":"218", "text":"Kabupaten Malinau"},
        {"id":"219", "text":"Kabupaten Maluku Barat Daya"},
        {"id":"220", "text":"Kabupaten Maluku Tengah"},
        {"id":"221", "text":"Kabupaten Maluku Tenggara"},
        {"id":"222", "text":"Kabupaten Maluku Tenggara Barat"},
        {"id":"223", "text":"Kabupaten Mamasa"},
        {"id":"224", "text":"Kabupaten Mamberamo Raya"},
        {"id":"225", "text":"Kabupaten Mamberamo Tengah"},
        {"id":"226", "text":"Kabupaten Mamuju"},
        {"id":"227", "text":"Kabupaten Mamuju Tengah"},
        {"id":"228", "text":"Kabupaten Mamuju Utara"},
        {"id":"229", "text":"Kabupaten Mandailing Natal"},
        {"id":"230", "text":"Kabupaten Manggarai"},
        {"id":"231", "text":"Kabupaten Manggarai Barat"},
        {"id":"232", "text":"Kabupaten Manggarai Timur"},
        {"id":"233", "text":"Kabupaten Manokwari"},
        {"id":"234", "text":"Kabupaten Manokwari Selatan"},
        {"id":"235", "text":"Kabupaten Mappi"},
        {"id":"236", "text":"Kabupaten Maros"},
        {"id":"237", "text":"Kabupaten Maybrat"},
        {"id":"238", "text":"Kabupaten Melawi"},
        {"id":"239", "text":"Kabupaten Mempawah"},
        {"id":"240", "text":"Kabupaten Merangin"},
        {"id":"241", "text":"Kabupaten Merauke"},
        {"id":"242", "text":"Kabupaten Mesuji"},
        {"id":"243", "text":"Kabupaten Mimika"},
        {"id":"244", "text":"Kabupaten Minahasa"},
        {"id":"245", "text":"Kabupaten Minahasa Selatan"},
        {"id":"246", "text":"Kabupaten Minahasa Tenggara"},
        {"id":"247", "text":"Kabupaten Minahasa Utara"},
        {"id":"248", "text":"Kabupaten Mojokerto"},
        {"id":"249", "text":"Kabupaten Morowali"},
        {"id":"250", "text":"Kabupaten Morowali Utara"},
        {"id":"251", "text":"Kabupaten Muara Enim"},
        {"id":"252", "text":"Kabupaten Muaro Jambi"},
        {"id":"253", "text":"Kabupaten Mukomuko"},
        {"id":"254", "text":"Kabupaten Muna"},
        {"id":"255", "text":"Kabupaten Muna Barat"},
        {"id":"256", "text":"Kabupaten Murung Raya"},
        {"id":"257", "text":"Kabupaten Musi Banyuasin"},
        {"id":"258", "text":"Kabupaten Musi Rawas"},
        {"id":"259", "text":"Kabupaten Musi Rawas Utara"},
        {"id":"260", "text":"Kabupaten Nabire"},
        {"id":"261", "text":"Kabupaten Nagan Raya"},
        {"id":"262", "text":"Kabupaten Nagekeo"},
        {"id":"263", "text":"Kabupaten Natuna"},
        {"id":"264", "text":"Kabupaten Nduga"},
        {"id":"265", "text":"Kabupaten Ngada"},
        {"id":"266", "text":"Kabupaten Nganjuk"},
        {"id":"267", "text":"Kabupaten Ngawi"},
        {"id":"268", "text":"Kabupaten Nias"},
        {"id":"269", "text":"Kabupaten Nias Barat"},
        {"id":"270", "text":"Kabupaten Nias Selatan"},
        {"id":"271", "text":"Kabupaten Nias Utara"},
        {"id":"272", "text":"Kabupaten Nunukan"},
        {"id":"273", "text":"Kabupaten Ogan Ilir"},
        {"id":"274", "text":"Kabupaten Ogan Komering Ilir"},
        {"id":"275", "text":"Kabupaten Ogan Komering Ulu"},
        {"id":"276", "text":"Kabupaten Ogan Komering Ulu Selatan"},
        {"id":"277", "text":"Kabupaten Ogan Komering Ulu Timur"},
        {"id":"278", "text":"Kabupaten Pacitan"},
        {"id":"279", "text":"Kabupaten Padang Lawas"},
        {"id":"280", "text":"Kabupaten Padang Lawas Utara"},
        {"id":"281", "text":"Kabupaten Padang Pariaman"},
        {"id":"282", "text":"Kabupaten Pakpak Bharat"},
        {"id":"283", "text":"Kabupaten Pamekasan"},
        {"id":"284", "text":"Kabupaten Pandeglang"},
        {"id":"285", "text":"Kabupaten Pangandaran"},
        {"id":"286", "text":"Kabupaten Pangkajene dan Kepulauan"},
        {"id":"287", "text":"Kabupaten Paniai"},
        {"id":"288", "text":"Kabupaten Parigi Moutong"},
        {"id":"289", "text":"Kabupaten Pasaman"},
        {"id":"290", "text":"Kabupaten Pasaman Barat"},
        {"id":"291", "text":"Kabupaten Paser"},
        {"id":"292", "text":"Kabupaten Pasuruan"},
        {"id":"293", "text":"Kabupaten Pati"},
        {"id":"294", "text":"Kabupaten Pegunungan Arfak"},
        {"id":"295", "text":"Kabupaten Pegunungan Bintang"},
        {"id":"296", "text":"Kabupaten Pekalongan"},
        {"id":"297", "text":"Kabupaten Pelalawan"},
        {"id":"298", "text":"Kabupaten Pemalang"},
        {"id":"299", "text":"Kabupaten Penajam Paser Utara"},
        {"id":"300", "text":"Kabupaten Penukal Abab Lematang Ilir"},
        {"id":"301", "text":"Kabupaten Pesawaran"},
        {"id":"302", "text":"Kabupaten Pesisir Barat"},
        {"id":"303", "text":"Kabupaten Pesisir Selatan"},
        {"id":"304", "text":"Kabupaten Pidie"},
        {"id":"305", "text":"Kabupaten Pidie Jaya"},
        {"id":"306", "text":"Kabupaten Pinrang"},
        {"id":"307", "text":"Kabupaten Pohuwato"},
        {"id":"308", "text":"Kabupaten Polewali Mandar"},
        {"id":"309", "text":"Kabupaten Ponorogo"},
        {"id":"310", "text":"Kabupaten Poso"},
        {"id":"311", "text":"Kabupaten Pringsewu"},
        {"id":"312", "text":"Kabupaten Probolinggo"},
        {"id":"313", "text":"Kabupaten Pulang Pisau"},
        {"id":"314", "text":"Kabupaten Pulau Morotai"},
        {"id":"315", "text":"Kabupaten Pulau Taliabu"},
        {"id":"316", "text":"Kabupaten Puncak"},
        {"id":"317", "text":"Kabupaten Puncak Jaya"},
        {"id":"318", "text":"Kabupaten Purbalingga"},
        {"id":"319", "text":"Kabupaten Purwakarta"},
        {"id":"320", "text":"Kabupaten Purworejo"},
        {"id":"321", "text":"Kabupaten Raja Ampat"},
        {"id":"322", "text":"Kabupaten Rejang Lebong"},
        {"id":"323", "text":"Kabupaten Rembang"},
        {"id":"324", "text":"Kabupaten Rokan Hilir"},
        {"id":"325", "text":"Kabupaten Rokan Hulu"},
        {"id":"326", "text":"Kabupaten Rote Ndao"},
        {"id":"327", "text":"Kabupaten Sabu Raijua"},
        {"id":"328", "text":"Kabupaten Sambas"},
        {"id":"329", "text":"Kabupaten Samosir"},
        {"id":"330", "text":"Kabupaten Sampang"},
        {"id":"331", "text":"Kabupaten Sanggau"},
        {"id":"332", "text":"Kabupaten Sarmi"},
        {"id":"333", "text":"Kabupaten Sarolangun"},
        {"id":"334", "text":"Kabupaten Sekadau"},
        {"id":"335", "text":"Kabupaten Seluma"},
        {"id":"336", "text":"Kabupaten Semarang"},
        {"id":"337", "text":"Kabupaten Seram Bagian Barat"},
        {"id":"338", "text":"Kabupaten Seram Bagian Timur"},
        {"id":"339", "text":"Kabupaten Serang"},
        {"id":"340", "text":"Kabupaten Serdang Bedagai"},
        {"id":"341", "text":"Kabupaten Seruyan"},
        {"id":"342", "text":"Kabupaten Siak"},
        {"id":"343", "text":"Kabupaten Sidenreng Rappang"},
        {"id":"344", "text":"Kabupaten Sidoarjo"},
        {"id":"345", "text":"Kabupaten Sigi"},
        {"id":"346", "text":"Kabupaten Sijunjung"},
        {"id":"347", "text":"Kabupaten Sikka"},
        {"id":"348", "text":"Kabupaten Simalungun"},
        {"id":"349", "text":"Kabupaten Simeulue"},
        {"id":"350", "text":"Kabupaten Sinjai"},
        {"id":"351", "text":"Kabupaten Sintang"},
        {"id":"352", "text":"Kabupaten Situbondo"},
        {"id":"353", "text":"Kabupaten Sleman"},
        {"id":"354", "text":"Kabupaten Solok"},
        {"id":"355", "text":"Kabupaten Solok Selatan"},
        {"id":"356", "text":"Kabupaten Soppeng"},
        {"id":"357", "text":"Kabupaten Sorong"},
        {"id":"358", "text":"Kabupaten Sorong Selatan"},
        {"id":"359", "text":"Kabupaten Sragen"},
        {"id":"360", "text":"Kabupaten Subang"},
        {"id":"361", "text":"Kabupaten Sukabumi"},
        {"id":"362", "text":"Kabupaten Sukamara"},
        {"id":"363", "text":"Kabupaten Sukoharjo"},
        {"id":"364", "text":"Kabupaten Sumba Barat"},
        {"id":"365", "text":"Kabupaten Sumba Barat Daya"},
        {"id":"366", "text":"Kabupaten Sumba Tengah"},
        {"id":"367", "text":"Kabupaten Sumba Timur"},
        {"id":"368", "text":"Kabupaten Sumbawa"},
        {"id":"369", "text":"Kabupaten Sumbawa Barat"},
        {"id":"370", "text":"Kabupaten Sumedang"},
        {"id":"371", "text":"Kabupaten Sumenep"},
        {"id":"372", "text":"Kabupaten Supiori"},
        {"id":"373", "text":"Kabupaten Tabalong"},
        {"id":"374", "text":"Kabupaten Tabanan"},
        {"id":"375", "text":"Kabupaten Takalar"},
        {"id":"376", "text":"Kabupaten Tambrauw"},
        {"id":"377", "text":"Kabupaten Tana Tidung"},
        {"id":"378", "text":"Kabupaten Tana Toraja"},
        {"id":"379", "text":"Kabupaten Tanah Bumbu"},
        {"id":"380", "text":"Kabupaten Tanah Datar"},
        {"id":"381", "text":"Kabupaten Tanah Laut"},
        {"id":"382", "text":"Kabupaten Tangerang"},
        {"id":"383", "text":"Kabupaten Tanggamus"},
        {"id":"384", "text":"Kabupaten Tanjung Jabung Barat"},
        {"id":"385", "text":"Kabupaten Tanjung Jabung Timur"},
        {"id":"386", "text":"Kabupaten Tapanuli Selatan"},
        {"id":"387", "text":"Kabupaten Tapanuli Tengah"},
        {"id":"388", "text":"Kabupaten Tapanuli Utara"},
        {"id":"389", "text":"Kabupaten Tapin"},
        {"id":"390", "text":"Kabupaten Tasikmalaya"},
        {"id":"391", "text":"Kabupaten Tebo"},
        {"id":"392", "text":"Kabupaten Tegal"},
        {"id":"393", "text":"Kabupaten Teluk Bintuni"},
        {"id":"394", "text":"Kabupaten Teluk Wondama"},
        {"id":"395", "text":"Kabupaten Temanggung"},
        {"id":"396", "text":"Kabupaten Timor Tengah Selatan"},
        {"id":"397", "text":"Kabupaten Timor Tengah Utara"},
        {"id":"398", "text":"Kabupaten Toba Samosir"},
        {"id":"399", "text":"Kabupaten Tojo Una-Una"},
        {"id":"400", "text":"Kabupaten Tolikara"},
        {"id":"401", "text":"Kabupaten Toli-Toli"},
        {"id":"402", "text":"Kabupaten Toraja Utara"},
        {"id":"403", "text":"Kabupaten Trenggalek"},
        {"id":"404", "text":"Kabupaten Tuban"},
        {"id":"405", "text":"Kabupaten Tulang Bawang"},
        {"id":"406", "text":"Kabupaten Tulang Bawang Barat"},
        {"id":"407", "text":"Kabupaten Tulungagung"},
        {"id":"408", "text":"Kabupaten Wajo"},
        {"id":"409", "text":"Kabupaten Wakatobi"},
        {"id":"410", "text":"Kabupaten Waropen"},
        {"id":"411", "text":"Kabupaten Way Kanan"},
        {"id":"412", "text":"Kabupaten Wonogiri"},
        {"id":"413", "text":"Kabupaten Wonosobo"},
        {"id":"414", "text":"Kabupaten Yahukimo"},
        {"id":"415", "text":"Kabupaten Yalimo"},
        {"id":"416", "text":"Kepulauan Maluku"},
        {"id":"417", "text":"Kota Administrasi Jakarta Barat"},
        {"id":"418", "text":"Kota Administrasi Jakarta Pusat"},
        {"id":"419", "text":"Kota Administrasi Jakarta Selatan"},
        {"id":"420", "text":"Kota Administrasi Jakarta Timur"},
        {"id":"421", "text":"Kota Administrasi Jakarta Utara"},
        {"id":"422", "text":"Kota Ambon"},
        {"id":"423", "text":"Kota Balikpapan"},
        {"id":"424", "text":"Kota Banda Aceh"},
        {"id":"425", "text":"Kota Bandar Lampung"},
        {"id":"426", "text":"Kota Bandung"},
        {"id":"427", "text":"Kota Banjar"},
        {"id":"428", "text":"Kota Banjarbaru"},
        {"id":"429", "text":"Kota Banjarmasin"},
        {"id":"430", "text":"Kota Batam"},
        {"id":"431", "text":"Kota Batu"},
        {"id":"432", "text":"Kota Bau-Bau"},
        {"id":"433", "text":"Kota Bekasi"},
        {"id":"434", "text":"Kota Bima"},
        {"id":"435", "text":"Kota Binjai"},
        {"id":"436", "text":"Kota Bitung"},
        {"id":"437", "text":"Kota Blitar"},
        {"id":"438", "text":"Kota Bogor"},
        {"id":"439", "text":"Kota Bontang"},
        {"id":"440", "text":"Kota Bukittinggi"},
        {"id":"441", "text":"Kota Cilegon"},
        {"id":"442", "text":"Kota Cimahi"},
        {"id":"443", "text":"Kota Cirebon"},
        {"id":"444", "text":"Kota Depok"},
        {"id":"445", "text":"Kota Dumai"},
        {"id":"446", "text":"Kota Gunungsitoli"},
        {"id":"447", "text":"Kota Jambi"},
        {"id":"448", "text":"Kota Kediri"},
        {"id":"449", "text":"Kota Kendari"},
        {"id":"450", "text":"Kota Kotamobagu"},
        {"id":"451", "text":"Kota Langsa"},
        {"id":"452", "text":"Kota Lhokseumawe"},
        {"id":"453", "text":"Kota Lubuklinggau"},
        {"id":"454", "text":"Kota Madiun"},
        {"id":"455", "text":"Kota Magelang"},
        {"id":"456", "text":"Kota Makassar"},
        {"id":"457", "text":"Kota Malang"},
        {"id":"458", "text":"Kota Manado"},
        {"id":"459", "text":"Kota Mataram"},
        {"id":"460", "text":"Kota Medan"},
        {"id":"461", "text":"Kota Metro"},
        {"id":"462", "text":"Kota Mojokerto"},
        {"id":"463", "text":"Kota Padang"},
        {"id":"464", "text":"Kota Padangpanjang"},
        {"id":"465", "text":"Kota Padangsidempuan"},
        {"id":"466", "text":"Kota Pagar Alam"},
        {"id":"467", "text":"Kota Palembang"},
        {"id":"468", "text":"Kota Palopo"},
        {"id":"469", "text":"Kota Parepare"},
        {"id":"470", "text":"Kota Pariaman"},
        {"id":"471", "text":"Kota Pasuruan"},
        {"id":"472", "text":"Kota Payakumbuh"},
        {"id":"473", "text":"Kota Pekalongan"},
        {"id":"474", "text":"Kota Pekanbaru"},
        {"id":"475", "text":"Kota Pematangsiantar"},
        {"id":"476", "text":"Kota Pontianak"},
        {"id":"477", "text":"Kota Prabumulih"},
        {"id":"478", "text":"Kota Probolinggo"},
        {"id":"479", "text":"Kota Sabang"},
        {"id":"480", "text":"Kota Salatiga"},
        {"id":"481", "text":"Kota Samarinda"},
        {"id":"482", "text":"Kota Sawahlunto"},
        {"id":"483", "text":"Kota Semarang"},
        {"id":"484", "text":"Kota Serang"},
        {"id":"485", "text":"Kota Sibolga"},
        {"id":"486", "text":"Kota Singkawang"},
        {"id":"487", "text":"Kota Solok"},
        {"id":"488", "text":"Kota Subulussalam"},
        {"id":"489", "text":"Kota Sukabumi"},
        {"id":"490", "text":"Kota Sungai Penuh"},
        {"id":"491", "text":"Kota Surabaya"},
        {"id":"492", "text":"Kota Surakarta"},
        {"id":"493", "text":"Kota Tangerang"},
        {"id":"494", "text":"Kota Tangerang Selatan"},
        {"id":"495", "text":"Kota Tanjung Pinang"},
        {"id":"496", "text":"Kota Tanjungbalai"},
        {"id":"497", "text":"Kota Tasikmalaya"},
        {"id":"498", "text":"Kota Tebing Tinggi"},
        {"id":"499", "text":"Kota Tegal"},
        {"id":"500", "text":"Kota Ternate"},
        {"id":"501", "text":"Kota Tidore Kepulauan"},
        {"id":"502", "text":"Kota Tomohon"},
        {"id":"503", "text":"Kota Tual"}
]';

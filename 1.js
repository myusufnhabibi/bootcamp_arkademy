function Biodata(nama, umur) {
	let biodata = {};
	biodata.name = nama;
	biodata.age = umur;
	biodata.address = 'Wergu wetan 05/04 Kota Kudus';
	biodata.hobbies = ['Ngoding', 'Olahraga', 'Ngegame'];
	biodata.is_married = false;
	biodata.list_school = [
		{
			name : 'SD 1 Wergu wetan',
			year_in : 2003,
			year_out : 2009
		},
		{
			name : 'SMP 5 Kudus',
			year_in : 2009,
			year_out : 2012
		},
		{
			name : 'SMA 2 Bae Kudus',
			year_in : 2012,
			year_out : 2015,
			major : 'IPS'
		},
		{
			name : 'Universitas Muria Kudus',
			year_in : 2015,
			year_out : 2019,
			major : 'Sistem Informasi'
		}
	];
	biodata.skills = [
		{
			skill_name: 'PHP',
			level: 'Advanced'
		},
		{
			skill_name: 'Javascript',
			level: 'Advanced'
		}
	];
	biodata.interest_in_coding = true;

	return JSON.stringify(biodata);
}

let yusuf = Biodata('Yusuf', 22);
console.log(yusuf)
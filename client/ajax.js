let cep = document.querySelector("#cep");

cep.onkeyup = () => {
  searchCEP();
}

async function searchCEP(){
  let cepValue = cep.value;

  if(cepValue.length != 9) return;

  const url = `https://viacep.com.br/ws/${cepValue}/json/`;

  let request = await fetch(url);
  let {bairro, localidade, logradouro, uf} = await request.json();

  let street = document.querySelector("#street");
  let neighborhood = document.querySelector("#neighborhood");
  let state = document.querySelector("#uf");
  let city = document.querySelector("#city");

  street.value = logradouro;
  neighborhood.value = bairro;
  state.value = uf;
  city.value = localidade;
}




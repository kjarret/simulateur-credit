const stepRange = document.getElementById('step-range');
const stepValue = document.getElementById('step-value');
const cards = document.querySelectorAll('.card');
const inputAmount = document.getElementById('amount');
let jsonData;
let amountVal;
let currentSteps = [];

function selectCard(clickedCard) {
  cards.forEach(card => {
    if (card === clickedCard) {
      card.classList.add('selected');
    } else {
      card.classList.remove('selected');
    }
  });
}

cards.forEach(card => {
  card.addEventListener('click', function () {
    const selectedOption = this.getAttribute('data-option');
    updateSteps(selectedOption);
  });
});

function updateSteps(option) {
  let jsonFile;
  if (option === 'prêt perso') {
    jsonFile = 'pret_perso.json';
  } else if (option === 'mobilité') {
    jsonFile = 'pret_mobilite.json';
  } else if (option === 'voiture neuve') {
    jsonFile = 'pret_voiture_neuve.json';
  } else if (option === 'voiture occasion') {
    jsonFile = 'pret_voiture_occasion.json';
  } else if (option === 'moto neuve') {
    jsonFile = 'pret_moto_neuve.json';
  } else if (option === 'moto occasion') {
    jsonFile = 'pret_moto_occasion.json';
  } else if (option === 'travaux') {
    jsonFile = 'pret_travaux.json';
  } else if (option === 'énergie') {
    jsonFile = 'pret_energie.json';
  }

  loadJSON(jsonFile);
}

function loadJSON(option) {
  const jsonFile = simulateur_credit_data[option];

  fetch(jsonFile)
    .then(response => {
      return response.json();
    })
    .then(data => {
      jsonData = data;
      amountVal = parseInt(inputAmount.value);
      currentSteps = generateStepsFromJSON(jsonData, amountVal);
      updateStepRange();
      calculateLoan(jsonData, amountVal);
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

function generateStepsFromJSON(jsonData, amount) {
  const steps = [];
  for (const key in jsonData) {
    if (key === '>50000' && amount > 50000) {
      const interestRates = jsonData[key];
      for (const month in interestRates) {
        if (interestRates[month] !== null) {
          steps.push(parseInt(month));
        }
      }
    } else if (key !== '>50000') {
      const range = key.split('-');
      const minAmount = parseFloat(range[0]);
      const maxAmount = parseFloat(range[1]);
      if (amount >= minAmount && amount <= maxAmount) {
        const interestRates = jsonData[key];
        for (const month in interestRates) {
          if (interestRates[month] !== null) {
            steps.push(parseInt(month));
          }
        }
      }
    }
  }
  return steps.sort((a, b) => a - b);
}

function updateStepRange() {
  stepRange.setAttribute('step', 1);
  stepRange.value = currentSteps.indexOf(Math.min(...currentSteps));

  if (currentSteps.length > 0) {
    stepRange.setAttribute('min', 0);
    stepRange.setAttribute('max', currentSteps.length - 1);
    stepValue.textContent = currentSteps[0];
    stepRange.disabled = false;
  } else {
    stepRange.disabled = true;
    stepValue.textContent = 'X';
  }
}

stepRange.addEventListener('input', function () {
  const value = stepRange.value;
  const selectedStep = currentSteps[value];

  if (jsonData && jsonData[selectedStep] !== null) {
    stepValue.textContent = selectedStep;
    calculateLoan(jsonData, amountVal);
  }
});

inputAmount.addEventListener('input', function () {
  amountVal = parseInt(this.value);
  currentSteps = generateStepsFromJSON(jsonData, amountVal);
  updateStepRange();
  calculateLoan(jsonData, amountVal);
  stepRange.value = currentSteps.indexOf(Math.min(...currentSteps));
});

function calculateLoan(data, loanAmount) {
  const loanTenure = parseInt(document.getElementById('step-value').textContent);
  let interestRate = null;
  for (const key in jsonData) {
    if (key === '>50000' && loanAmount > 50000) {
      const interestRates = jsonData[key];
      if (interestRates[loanTenure.toString()] !== null) {
        interestRate = interestRates[loanTenure.toString()];
        break;
      }
    } else if (key !== '>50000') {
      const range = key.split('-');
      const minAmount = parseFloat(range[0]);
      const maxAmount = parseFloat(range[1]);
      if (loanAmount >= minAmount && loanAmount <= maxAmount) {
        const interestRates = jsonData[key];
        if (interestRates[loanTenure.toString()] !== null) {
          interestRate = interestRates[loanTenure.toString()];
          break;
        }
      }
    }
  }
  if (interestRate !== null) {
    const monthlyInterestRate = (interestRate / 100) / 12;
    const monthlyPayment = (loanAmount * monthlyInterestRate) / (1 - Math.pow(1 + monthlyInterestRate, -loanTenure));
    const totalRepayment = monthlyPayment * loanTenure;
    document.getElementById('monthly-payment').innerText = monthlyPayment.toFixed(2);
    document.getElementById('total-repayment').innerText = totalRepayment.toFixed(2);
    document.getElementById('interest-rate').innerText = interestRate;
    document.getElementById('month').innerText = stepValue.textContent;
  } else {
    document.getElementById('monthly-payment').innerText = 'N/A';
    document.getElementById('total-repayment').innerText = 'Montant indisponible';
    document.getElementById('interest-rate').innerText = 'N/A';
  }
}

updateSteps('prêt perso');

const stepRange = document.getElementById('step-range');
const stepValue = document.getElementById('step-value');
const cards = document.querySelectorAll('.card');
const inputAmount = document.getElementById('amount');
<<<<<<< HEAD
=======

const montant = document.getElementById('amount-payment');
const duree = document.getElementById('month');
const taeg = document.getElementById('interest-rate');
const totalPayer = document.getElementById('total-repayment');
const mensualite = document.getElementById('monthly-payment');

>>>>>>> f2e047c (Fix some bugs and add style)
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
<<<<<<< HEAD
  } else {
    stepRange.disabled = true;
    stepValue.textContent = 'X';
=======

    displayErrorMessageWithDelay();
  } else {
    stepRange.disabled = true;
    stepValue.textContent = '0';
    document.getElementById('error-message').style.display = 'block';
  }
}

function displayErrorMessageWithDelay() {
  if (stepValue.textContent === '0' || stepValue.textContent === '') {
    setTimeout(function () {
      if (stepValue.textContent === '0' || stepValue.textContent === '') {
        document.getElementById('error-message').style.display = 'block';
      }
    }, 2000);
  } else {
    document.getElementById('error-message').style.display = 'none';
>>>>>>> f2e047c (Fix some bugs and add style)
  }
}

stepRange.addEventListener('input', function () {
  const value = stepRange.value;
  const selectedStep = currentSteps[value];

  if (jsonData && jsonData[selectedStep] !== null) {
    stepValue.textContent = selectedStep;
    calculateLoan(jsonData, amountVal);
<<<<<<< HEAD
  }
});

=======
    
    displayErrorMessageWithDelay();
  }
});


>>>>>>> f2e047c (Fix some bugs and add style)
inputAmount.addEventListener('input', function () {
  amountVal = parseInt(this.value);
  currentSteps = generateStepsFromJSON(jsonData, amountVal);
  updateStepRange();
  calculateLoan(jsonData, amountVal);
  stepRange.value = currentSteps.indexOf(Math.min(...currentSteps));
<<<<<<< HEAD
});

function calculateLoan(data, loanAmount) {
  const loanTenure = parseInt(document.getElementById('step-value').textContent);
  let interestRate = null;
=======
  montant.innerText = inputAmount.value;
});




function isRateDefinedForAmount(jsonData, loanAmount, loanTenure) {
>>>>>>> f2e047c (Fix some bugs and add style)
  for (const key in jsonData) {
    if (key === '>50000' && loanAmount > 50000) {
      const interestRates = jsonData[key];
      if (interestRates[loanTenure.toString()] !== null) {
<<<<<<< HEAD
        interestRate = interestRates[loanTenure.toString()];
        break;
=======
        return true;
>>>>>>> f2e047c (Fix some bugs and add style)
      }
    } else if (key !== '>50000') {
      const range = key.split('-');
      const minAmount = parseFloat(range[0]);
      const maxAmount = parseFloat(range[1]);
      if (loanAmount >= minAmount && loanAmount <= maxAmount) {
        const interestRates = jsonData[key];
        if (interestRates[loanTenure.toString()] !== null) {
<<<<<<< HEAD
          interestRate = interestRates[loanTenure.toString()];
          break;
=======
          return true;
>>>>>>> f2e047c (Fix some bugs and add style)
        }
      }
    }
  }
<<<<<<< HEAD
=======
  return false;
}

function calculateLoan(data, loanAmount) {
  const loanTenure = parseInt(document.getElementById('step-value').textContent);
  let interestRate = null;
  if (inputAmount.value.trim() === "") {
    document.getElementById('error-message').style.display = 'none';
    montant.innerText = '0';
    taeg.innerText = '0';
    totalPayer.innerText = '0';
    mensualite.innerText = '0';
  } else if (isRateDefinedForAmount(jsonData, loanAmount, loanTenure)) {
    for (const key in jsonData) {
      if ((key === '>50000' && loanAmount > 50000) || (key === '>500' && loanAmount > 500)) {
        const interestRates = jsonData[key];
        if (interestRates[loanTenure.toString()] !== null) {
          interestRate = interestRates[loanTenure.toString()];
          break;
        }
      } else if (key !== '>50000' && key !== '>500') {
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
  } else {
    montant.innerText = '0';
    taeg.innerText = '0';
    totalPayer.innerText = '0';
    mensualite.innerText = '0';
  }

>>>>>>> f2e047c (Fix some bugs and add style)
  if (interestRate !== null) {
    const monthlyInterestRate = (interestRate / 100) / 12;
    const monthlyPayment = (loanAmount * monthlyInterestRate) / (1 - Math.pow(1 + monthlyInterestRate, -loanTenure));
    const totalRepayment = monthlyPayment * loanTenure;
<<<<<<< HEAD
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
=======

    montant.innerText = inputAmount.value;
    duree.innerText = stepValue.textContent;
    taeg.innerText = isNaN(interestRate) ? '0' : interestRate;
    totalPayer.innerText = isNaN(totalRepayment) ? '0' : totalRepayment.toFixed(2);
    mensualite.innerText = isNaN(monthlyPayment) ? '0' : monthlyPayment.toFixed(2);
  }
}

updateSteps('prêt perso');
>>>>>>> f2e047c (Fix some bugs and add style)

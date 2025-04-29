// Set API Base URL
const apiBase = "http://localhost/Wallet-System/api/";

// Create a new user
async function createUser() {
  const name = document.getElementById('name').value.trim();
  const email = document.getElementById('email').value.trim();
  const password = document.getElementById('password').value.trim();
  const dob = document.getElementById('dob').value.trim();
  const resultDiv = document.getElementById('userResult');
  console.log(resultDiv);
  

  if (!name || !email || !password || !dob) {
    resultDiv.style.color = 'red';
    resultDiv.innerText = 'Please fill all fields!';
    return;
  }

  try {
    const res = await fetch(apiBase + 'create_user', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ name, email, password, dob })
    });

    const data = await res.json();
    console.log(data);
    

    if (res.ok) {
      console.log('sssssssssssssssss');
      
      resultDiv.style.color = 'green';
      resultDiv.innerText = data.message || 'User created successfully!';
      document.getElementById('name').value = '';
      document.getElementById('email').value = '';
      document.getElementById('password').value = '';
      document.getElementById('dob').value = '';
    } else {
      console.log('aaaaaaaaaaa');
      
      resultDiv.style.color = 'red';
      resultDiv.innerText = data.error || 'Something went wrong';
    }
  } catch (error) {
    console.log('vvvvvvvvvvv');
    
    resultDiv.style.color = 'red';
    resultDiv.innerText = error.message || 'Server error';
  }
}

// Load users into dropdown
async function loadUsers(selectId) {
  try {
    const res = await fetch(apiBase + '../data/users.json');
    const users = await res.json();

    const select = document.getElementById(selectId);
    select.innerHTML = '<option value="">Select User</option>';

    users.forEach(user => {
      const option = document.createElement('option');
      option.value = user.user_id;
      option.textContent = `${user.name} (${user.email})`;
      select.appendChild(option);
    });
  } catch (error) {
    console.error('Error loading users:', error);
  }
}

// Deposit money
async function makeDeposit() {
  const userId = document.getElementById('depositUserId').value;
  const amount = document.getElementById('depositAmount').value;
  const resultDiv = document.getElementById('depositResult');

  if (!userId || !amount) {
    resultDiv.style.color = 'red';
    resultDiv.innerText = 'Please select user and amount!';
    return;
  }

  try {
    const res = await fetch(apiBase + 'deposit', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ user_id: userId, amount: parseFloat(amount) })
    });

    const data = await res.json();

    if (res.ok) {
      resultDiv.style.color = 'green';
      resultDiv.innerText = data.message || 'Deposit successful!';
      document.getElementById('depositAmount').value = '';
    } else {
      resultDiv.style.color = 'red';
      resultDiv.innerText = data.error || 'Something went wrong';
    }
  } catch (error) {
    resultDiv.style.color = 'red';
    resultDiv.innerText = error.message || 'Server error';
  }
}

// Withdraw money
async function makeWithdrawal() {
  const userId = document.getElementById('withdrawUserId').value;
  const amount = document.getElementById('withdrawAmount').value;
  const resultDiv = document.getElementById('withdrawResult');

  if (!userId || !amount) {
    resultDiv.style.color = 'red';
    resultDiv.innerText = 'Please select user and amount!';
    return;
  }

  try {
    const res = await fetch(apiBase + 'withdraw', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ user_id: userId, amount: parseFloat(amount) })
    });

    const data = await res.json();

    if (res.ok) {
      resultDiv.style.color = 'green';
      resultDiv.innerText = data.message || 'Withdrawal successful!';
      document.getElementById('withdrawAmount').value = '';
    } else {
      resultDiv.style.color = 'red';
      resultDiv.innerText = data.error || 'Something went wrong';
    }
  } catch (error) {
    resultDiv.style.color = 'red';
    resultDiv.innerText = error.message || 'Server error';
  }
}

// Check user balance and load transactions
async function checkUserBalance() {
  const userId = document.getElementById('balanceUserId').value;
  const balanceInput = document.getElementById('userBalance');
  const tableBody = document.getElementById('transactionsTable').querySelector('tbody');

  if (!userId) {
    alert('Please select a user');
    return;
  }

  // Clear previous data
  balanceInput.value = '';
  tableBody.innerHTML = '';

  try {
    const balanceRes = await fetch(apiBase + 'balance?user_id=' + userId);
    const balanceData = await balanceRes.json();
    if (balanceRes.ok) {
      balanceInput.value = balanceData.balance;
    } else {
      alert(balanceData.error || 'Error getting balance');
      return;
    }

    const txnRes = await fetch(apiBase + 'transactions?user_id=' + userId);
    const txnData = await txnRes.json();

    txnData.forEach((txn, index) => {
      const dateOnly = txn.timestamp.split(' ')[0];

      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${index + 1}</td>
        <td>${txn.type}</td>
        <td>${txn.amount}</td>
        <td>${dateOnly}</td>
      `;
      tableBody.appendChild(row);
    });
  } catch (error) {
    console.error('Error:', error);
    alert('Server error');
  }
}

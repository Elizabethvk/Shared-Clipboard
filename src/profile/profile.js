document.addEventListener('DOMContentLoaded', function () {
    window.searchUsers = async function () {
        const searchInput = document.getElementById('search').value;

        if (searchInput.trim() !== '') {
            try {
                const response = await fetch(`/src/profile/search.php?username=${searchInput}`);
                const data = await response.json();

                if (response.ok) {
                    displayResults(data);
                } else {
                    console.error('Error fetching data:', data);
                    displayError('Server error. Please try again later.');
                }
            } catch (error) {
                console.error('Error fetching data:', error);
                displayError('Error fetching data. Please try again.');
            }
        }
    };

    function displayResults(users) {
        const resultsContainer = document.getElementById('results');
        resultsContainer.innerHTML = '';

        if (users.length === 0) {
            resultsContainer.innerHTML = '<p>Няма намерени потребители с такъв никнейм.</p>';
            return;
        }

        const table = document.createElement('table');
        table.innerHTML = `
            <thead>
                <tr>
                    <th>Никнейм</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        `;

        const tbody = table.querySelector('tbody');
        users.forEach(user => {
            const row = document.createElement('tr');
            const buttonText = user.isSubscribed ? 'Отписване' : 'Абониране';

            row.innerHTML = `
                <td>${user.username}</td>
                <td><button data-username="${user.username}" onclick="toggleSubscription('${user.username}', ${user.isSubscribed})">${buttonText}</button></td>
            `;

            tbody.appendChild(row);
        });

        resultsContainer.appendChild(table);
    }

    window.toggleSubscription = async function (username, isSubscribed) {
        try {
            const response = await fetch(`/src/profile/subscribe.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `username=${encodeURIComponent(username)}`, // Make sure to encode the parameter
            });
            
            if (response.ok) {
                const data = await response.json();
    
                // Update the UI based on the new subscription status
                updateSubscriptionUI(username, !isSubscribed, data.action);
    
                // Fetch the updated user list and refresh the display
                fetchUpdatedUserList();
            } else {
                console.error('Error handling subscription:', response.statusText);
                displayError('Server error. Please try again later.');
            }
        } catch (error) {
            console.error('Error handling subscription:', error);
            displayError('Error handling subscription. Please try again.');
        }
    };

    function displayError(message) {
        const errorContainer = document.getElementById('error');
        errorContainer.innerHTML = `<p>${message}</p>`;
    }

});

function updateSubscriptionUI(username, isSubscribed, action) {
    const button = document.querySelector(`button[data-username="${username}"]`);
    if (button) {
        button.innerText = action === 'subscribe' ? 'Отписване' : 'Абониране';
    }
}

async function fetchUpdatedUserList() {
    try {
        const searchInput = document.getElementById('search').value;
        const response = await fetch(`/src/profile/search.php?username=${searchInput}`);
        const data = await response.json();

        if (response.ok) {
            displayResults(data);
        } else {
            console.error('Error fetching updated user list:', data);
            displayError('Server error. Please try again later.');
        }
    } catch (error) {
        console.error('Error fetching updated user list:', error);
        displayError('Error fetching updated user list. Please try again.');
    }
}

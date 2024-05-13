document.addEventListener('DOMContentLoaded', function() {

  const addEmployeeBtn = document.getElementById('addEmployeeBtn');
  const employeeForm = document.getElementById('employeeForm');
  const employeeTableBody = document.getElementById('employeeTable').getElementsByTagName('tbody')[0];
  const employeeManagementForm = document.getElementById('employeeManagementForm');
  const searchEmployee = document.getElementById('searchEmployee');

  // Function to toggle the display of the employee form
  addEmployeeBtn.addEventListener('click', function() {
    employeeForm.style.display = employeeForm.style.display === 'none' ? 'block' : 'none';
  });

  // Function to handle the submission of the employee form
  employeeManagementForm.addEventListener('submit', function(event) {
    event.preventDefault();

    const name = document.getElementById('name').value;
    const employeeId = document.getElementById('employeeId').value;
    const date = document.getElementById('date').value;
    const company = document.getElementById('company').value;
    const status = document.getElementById('status').value;
    const file = document.getElementById('file').files[0];

    // TODO: Implement file handling

    // Add new employee to the table
    let newRow = employeeTableBody.insertRow();
    newRow.innerHTML = `
      <td>${name}</td>
      <td>${employeeId}</td>
      <td>${date}</td>
      <td>${status}</td>
      <td>${company}</td>
      <td><a href="#" class="pdf-link">View</a></td>
      <td>
        <button class="edit">Edit</button>
        <button class="archive">Archive</button>
      </td>
    `;

    // Reset the form
    employeeManagementForm.reset();
    // Hide the form
    employeeForm.style.display = 'none';
  });

  // Function to handle search filtering
  searchEmployee.addEventListener('keyup', function() {
    let searchValue = this.value.toLowerCase();
    Array.from(employeeTableBody.getElementsByTagName('tr')).forEach(function(row) {
      row.style.display = row.textContent.toLowerCase().includes(searchValue) ? '' : 'none';
    });
  });

  // TODO: Implement edit and archive functionality

});

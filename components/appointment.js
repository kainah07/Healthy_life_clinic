document.addEventListener("DOMContentLoaded", function () {
  // JavaScript date & time picker
  flatpickr("#appointment_datetime", { // Initialize the date picker using Flatpickr
      enableTime: true,
      dateFormat: "Y-m-d H:i", // ✅ Space instead of hyphen between date and time
      minDate: "today",
      minTime: "09:00",
      maxTime: "18:00",
      time_24hr: false
  });

  function fetchProviders(specialization = "") {
      // Send an AJAX request to fetch providers based on specialization
      $.ajax({
          url: "provider_search.php", // Calls backend script for provider data
          type: "GET",
          data: { specialization: specialization },  // Sends user input to filter results
          dataType: "json",
          success: function(response) {
              let providerDropdown = $("#provider_id");
              providerDropdown.empty();  // Clears previous options
              providerDropdown.append('<option value="">Select Provider</option>');
              if (response.length > 0) {
                  response.forEach(provider => {
                      providerDropdown.append(`<option value="${provider.provider_id}">
                          ${provider.first_name} ${provider.last_name}
                      </option>`);
                  });
              } else {
                  // Displays a message if no providers match the specialization
                  providerDropdown.append('<option value="">No providers found. Try a different specialization.</option>');
              }
          },
          error: function() {
              alert("Error fetching providers.");
          }
      });
  }

   // Fetch providers when the page loads (default: all providers)
  fetchProviders();

  // Handle provider search when the 'Search' button is clicked
  $("#searchButton").on("click", function() {
      let specialization = $("#specialization").val().trim();
      fetchProviders(specialization);
  });

  // Handle reset functionality to clear specialization input and reload all providers
  $("#resetButton").on("click", function() {
      $("#specialization").val("");
      fetchProviders();
  });
});
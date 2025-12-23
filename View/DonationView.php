<?php
require_once "ViewAbst.php";
require_once  "../Model/DonorModel.php";

class DonationsView extends ViewAbst
{
    function ShowDonationsTable($rows)
    {
        $donorModel = new DonorModel();
        echo ('
            <!DOCTYPE html>
            <html lang="en">
            
            <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" href="../CSS/CRUD.css">
                    <link rel="stylesheet" href="../CSS/filter.css">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
                    <link rel="icon" href="../Resources/logo.ico">
                    <title>Donations</title>
            </head>
            
            <body>
                <header>
                        <h1>Donation Database</h1>
                        <nav>
                            <ul>
                                <a href="../Controller/AdminController.php"><li>Dashboard</li></a>
                                <a href="../Controller/DonorController.php"><li>Donors</li></a>
                                <a href="../Controller/AdminController.php?cmd=logout"><li>Logout</li></a>
                            </ul>
                        </nav>
                </header>
                
                <div class="container">
                    <div class="filter-section">
                        <h2>Filter Reports</h2>
                        <div class="filter-group">
                            <div class="filter-item">
                                <label for="filterPeriod">Date Range:</label>
                                <select id="filterPeriod" onchange="handlePeriodChange()">
                                    <option value="all">All Time</option>
                                    <option value="today">Today</option>
                                    <option value="week">This Week</option>
                                    <option value="month">This Month</option>
                                    <option value="custom">Custom Range</option>
                                </select>
                            </div>
                            <div class="filter-item">
                                <label for="startDate">Start Date:</label>
                                <input type="date" id="startDate" disabled onchange="applyFilters()">
                            </div>
                            <div class="filter-item">
                                <label for="endDate">End Date:</label>
                                <input type="date" id="endDate" disabled onchange="applyFilters()">
                            </div>
                        </div>
                        <div class="filter-buttons">
                            <button class="filter-btn" onclick="applyFilters()">Apply Filters</button>
                            <button class="filter-btn reset" onclick="resetFilters()">Reset Filters</button>
                        </div>
                        <div class="filter-info">
                            Showing <span id="recordCount">0</span> records
                        </div>
                    </div>
                    <div class="object-display">
                        <table class="object-display-table" id="donationTable">
                            <thead>
                            <tr>
                                <th>Donation ID</th>
                                <th>Donor Name</th>
                                <th>Amount Donated</th>
                                <th>Donation Date</th>
                                <th>action</th>
                            </tr>
                            </thead>
        ');
        foreach ($rows as $row) {
            $donorModel->getById($row['donor_id']);
            echo ('
                            <tr>
                                <td>' . $row['id'] . '</td>
                                <td>' . $donorModel->getUserName() . '</td>
                                <td>' . $row['total_cost'] . 'EGP</td>
                                <td>' . $row['donation_date'] . '</td>
                                <td>
                                    <a href="DonationDetailsController.php?id=' . $row['id'] . '" class="btn">
                                    <i class="fas fa-edit"></i> Details
                                    </a>
                                </td>
                            </tr>
            ');
        }
        echo ('
                        </table>
                    </div>
                </div>
                <script>
                    // Handle period dropdown change
                    function handlePeriodChange() {
                        const period = document.getElementById("filterPeriod").value;
                        const startDate = document.getElementById("startDate");
                        const endDate = document.getElementById("endDate");
                        
                        if (period === "custom") {
                            startDate.disabled = false;
                            endDate.disabled = false;
                            startDate.focus();
                        } else {
                            startDate.disabled = true;
                            endDate.disabled = true;
                            startDate.value = "";
                            endDate.value = "";
                        }
                        
                        applyFilters();
                    }
                    
                    // Get date range based on period
                    function getDateRange(period) {
                        const today = new Date();
                        let startDate, endDate = today;
                        
                        switch(period) {
                            case "today":
                                startDate = new Date(today);
                                break;
                            case "week":
                                startDate = new Date(today);
                                startDate.setDate(today.getDate() - today.getDay());
                                break;
                            case "month":
                                startDate = new Date(today.getFullYear(), today.getMonth(), 1);
                                break;
                            case "all":
                            default:
                                return null;
                        }
                        return {
                            start: formatLocalDate(startDate),
                            end: formatLocalDate(endDate)
                        };
                    }
                    
                    // Apply filters to the table
                    function applyFilters() {
                        const periodFilter = document.getElementById("filterPeriod").value;
                        const customStart = document.getElementById("startDate").value;
                        const customEnd = document.getElementById("endDate").value;
                        
                        let dateRange = null;
                        if (periodFilter === "custom" && (customStart || customEnd)) {
                            dateRange = {
                                start: customStart,
                                end: customEnd
                            };
                        } else if (periodFilter !== "all") {
                            dateRange = getDateRange(periodFilter);
                        }
                        
                        const tableRows = document.querySelectorAll("#donationTable tbody tr");
                        let visibleCount = 0;
                        
                        tableRows.forEach(row => {
                            let shouldShow = true;
                                                        
                            // Check date filter
                            if (shouldShow && dateRange) {
                                const dateCell = row.cells[3].textContent.trim();
                                const rowDate = dateCell.split(" ")[0]; // Extract date part
                                shouldShow = shouldShow && rowDate >= dateRange.start && rowDate <= dateRange.end;
                            }
                            
                            row.style.display = shouldShow ? "" : "none";
                            if (shouldShow) visibleCount++;
                        });
                        
                        updateRecordCount();
                    }
                    
                    // Update record count display
                    function updateRecordCount() {
                        const visibleRows = document.querySelectorAll("#donationTable tbody tr[style*=\"display: \"]").length;
                        const displayRows = Array.from(document.querySelectorAll("#donationTable tbody tr")).filter(row => row.style.display !== "none").length;
                        document.getElementById("recordCount").textContent = displayRows;
                    }
                    
                    // Reset all filters
                    function resetFilters() {
                        document.getElementById("filterPeriod").value = "all";
                        document.getElementById("startDate").value = "";
                        document.getElementById("endDate").value = "";
                        document.getElementById("startDate").disabled = true;
                        document.getElementById("endDate").disabled = true;
                        
                        const tableRows = document.querySelectorAll("#donationTable tbody tr");
                        tableRows.forEach(row => row.style.display = "");
                        
                        updateRecordCount();
                    }


                    function formatLocalDate(date) {
                        const y = date.getFullYear();
                        const m = String(date.getMonth() + 1).padStart(2, "0");
                        const d = String(date.getDate()).padStart(2, "0");
                        return `${y}-${m}-${d}`;
                    }
                    
                    // Initialize page on load
                    window.addEventListener("load", initializePage);
                </script>
            </body>
            </html>
        ');
    }
}

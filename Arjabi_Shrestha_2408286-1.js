// Student Name: Arjabi Shrestha
// Student id: 2408286

// DOM elements for search functionality
const searchBox = document.querySelector(".search input");
const searchBtn = document.querySelector(".search button");

// Asynchronous function to fetch real time weather data for a given city
async function currentWeather(city) {
    // if nothing is entered, alerts user to enter a city name
    if (city === '') {
        alert('Please enter city name.');
        return;
    }
    try{
    //The API url is updated when a city is provided
        if (city) {
            //fetching the last index data from database "Weather_App"
            let response = await fetch(
                `http://localhost/Weather_App/Arjabi_Shrestha_2408286_phpfile1.php?city=${city}`
            );
            
            // Parsing the fetched data as json
            let data = await response.json();
            console.log(data);
            
            // Update the UI with the fetched data
            document.querySelector(".icon-name").innerHTML = data.weather_condition;

            let imageId = data.weather_icon;
            const iconUrl = `http://openweathermap.org/img/wn/${imageId}@2x.png`;
            document.querySelector(".weather_icon").src = iconUrl;

            document.querySelector(".city").innerHTML = data.city;
            document.querySelector(".temp").innerHTML = data.temp+"°C";
            
            // formating the unix timestamp as day,month,date 
            let date = new Date(data.day_and_date*1000).toLocaleDateString("en-US",{
                weekday:"short",
                day:"numeric",
                month:"short"
            })      

            document.querySelector(".date").innerHTML = date;
            document.querySelector(".wind").innerHTML = data.wind_speed + " km/h";
            document.querySelector(".humidity").innerHTML = data.humidity + "%";
            document.querySelector(".pressure").innerHTML = data.pressure + " hPa";

            document.querySelector(".past_title").innerHTML = data.city+"'s Past Week's Searched Data";
        }        
    }
    catch (error){
        //Handle errors during the API request
        console.error("Error fetching weather data:", error.message);
    }
}

// Asynchronous function to fetch and display past weather data for a given city
async function displayPastData(city) {
    try{
        // Fetch data from the PHP script for past weather data only of the city entered 
        let response = await fetch(
            `http://localhost/Weather_App/Arjabi_Shrestha_2408286_phpfile2.php?city=${city}`
        );
        
        // Parsing the fetched data as json
        let data = await response.json();
        console.log(data);
        
        //extracting the length of array of fetched data
        let length_of_array = data.length;
        
        // getting data from the last index of array first and then  and moving towards the first index as the latest data is in the last index
        const last7Data = data.slice(-length_of_array);
        
        // Accessing the HTML table element
        const table = document.getElementById('last_week_data');
        
        // array to keep track of displayed dates
        let displayedDates = [];
        
        //to keep track of how many days are displayed in the UI
        var count_days = 0;

        // to clear old data
        table.innerHTML = '';
        
        // iterating through the array
        for(i=length_of_array-1;i>=0;i--){         
            let imageId = last7Data[i]['weather_icon'];
            const iconUrl = `http://openweathermap.org/img/wn/${imageId}@2x.png`;

            let tr = document.createElement("tr");

            // formating the unix timestamp as day,month,date 
            let date = new Date(last7Data[i]['day_and_date']*1000).toLocaleDateString("en-US",{
                    weekday:"short",
                    day:"numeric",
                    month:"short"
             })

            // Skip entry if date is already displayed
            if (displayedDates.includes(date)) {
                continue; // Skip this entry
            }

            // Add date to displayedDates array
            displayedDates.push(date);

            // Update the UI with the fetched data
            tr.innerHTML = `
                <td>${date}</td>
                <td><img id="myImage" src="${iconUrl} "></td>
                    
                <td>${last7Data[i]['temp']+" °C"}</td>
                <td>${last7Data[i]['wind_speed']+ " km/h"}</td>
                <td>${last7Data[i]['humidity']+ "%"}</td>
                <td>${last7Data[i]['pressure']+ " hPa"}</td>
            `;
            
            // Appending  new row to the table
            table.appendChild(tr);

            count_days = count_days+1;
            // Break the loop if 7 days are displayed in the UI
            if(count_days == 7 ){
                break;
            }
        }
    }     
    catch (error) {
        // Handle errors (e.g., network issues, server errors)
        console.error('Error fetching data:', error.message);
    }  
}

//calling currentWeather() function with default city
currentWeather("Aligarh");

//calling displayPastData() function with default city
displayPastData("Aligarh");

// Event listener for the search button
searchBtn.addEventListener("click", async () => {
    //calling currentWeather() function with city entered as argument
    currentWeather(searchBox.value);

    // Delay for a short time to ensure that the weather data is fetched before displaying past data
    await new Promise(resolve => setTimeout(resolve, 800));

    // calling displayPastData() function with city entered as argument
    displayPastData(searchBox.value);

});

// Event listener for the search box on keydown event (Enter key)
searchBox.addEventListener("keydown", async (event) => {
    if (event.key === "Enter") {
       //calling currentWeather() function with city entered as argument
        currentWeather(searchBox.value);

        // Delay for a short time to ensure that the weather data is fetched before displaying past data
        await new Promise(resolve => setTimeout(resolve, 800));
        
        // calling displayPastData() function with city entered as argument
        displayPastData(searchBox.value);
    }
});

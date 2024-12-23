
function setSelect(branches){
    const $select = $('<select>', {
        name: 'branchID',
        id: 'branchID',
        required: true,
        class: 'appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5',
    });

    // Add the default option
    $select.append($('<option>', {
        value: '',
        text: 'Select a branch',
        disabled: true,
        selected: true,
    }));
    // Append options dynamically
    branches.forEach(branch => {
        $select.append($('<option>', {
            value: branch.BranchID,
            text: branch.Name,
        }));
    });
    $('#studentIDTemplete').append($select);

}

$(document).ready(function(){
    $("#role").change(function(){
        var role = $(this).val();
        if(role == 'customer'){ 
        document.getElementById('studentIDTemplete').innerHTML =  `<label for="ID" class=" block text-sm font-medium leading-5 text-gray-700 ">
                                    Student ID
                                </label>
                                <div class="mt-1 rounded-md shadow-sm">
                                    <input id="studentID" name="studentID" type="text" required=""
                                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                </div>`;

        }
        else{
            document.getElementById('studentIDTemplete').innerHTML = `   <label for="position" class="block text-sm font-medium leading-5 text-gray-700">
                                    Position
                                </label>
                                <div class="mt-1 rounded-md shadow-sm" >
                                    <input id="position" name="position" type="text" required=""
                                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                </div>
                                <br>
                                    <label for="branchID"
                                    class="block text-sm font-medium leading-5 text-gray-700">
                                    BranchID
                                </label>
                            `;
                        fetch('retrieveBranch.php')
                        .then(response => response.json())
                        .then(branches => {
                            setSelect(branches);
                            }
                        )
                          
            // </div>`;
            
            // ); // Outputs: John

        }
        
        })
    });


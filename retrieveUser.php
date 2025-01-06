<?php
require 'dbconfig.php';


$stmt = $conn->prepare("SELECT * FROM user");
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach(array_reverse($results) as $result){
    $UserID= $result['UserID'];
    $email = $result['Email'];
    $username = $result['Username'];
    $role = $result['Role'];
    if($role=='customer'){
   
        $stmt = $conn->prepare("SELECT * FROM customer WHERE UserID = :UserID");
        $stmt->bindParam(':UserID', $UserID);
        $stmt->execute();
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '
        <tr class="odd:bg-blue-50">
            <td class="p-4 text-sm">
                <div class="flex items-center cursor-pointer w-max">
                    <div class="ml-4">
                        <p class="text-sm text-black">' . $username . '</p>
                        <p class="text-xs text-gray-500 mt-0.5">' . $email . '</p>
                    </div>
                </div>
            </td>
            <td class="p-4 text-sm text-black">
                ' . $role . '
            </td>
            <td class="p-4">
                <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="edit">
                    <a href="editCustomerUser.php?editUserID=' . $UserID . '">Edit</a> 
                </button>
                <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="view">
                    <a href="viewCustomerProfile.php?viewUserID=' . $UserID . '">View</a>
                </button>
                <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="delete" >
                    <a href="deleteUser.php?deleteUserID=' . $UserID . '&role=' . $role . '">Delete</a>
                </button>
                ';
        if($customer["VerificationStatus"] == "pending"){
            echo '<button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="verify">
                    <a href="verifyUser.php?verifyUserID=' . $UserID . '">Verify</a>
                </button>
            </td>
            
        </tr>';
        }
        
    }
    elseif($role=='staff'){
        echo '
        <tr class="odd:bg-blue-50">
            <td class="p-4 text-sm">
                <div class="flex items-center cursor-pointer w-max">
                    <div class="ml-4">
                        <p class="text-sm text-black">' . $username . '</p>
                        <p class="text-xs text-gray-500 mt-0.5">' . $email . '</p>
                    </div>
                </div>
            </td>
            <td class="p-4 text-sm text-black">
                ' . $role . '
            </td>
            <td class="p-4">
                <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="edit">
                    <a href="editStaffUser.php?editUserID=' . $UserID . '">Edit</a>
                </button>
                <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="view">
                    <a href="viewStaffProfile.php?viewUserID=' . $UserID . '">View</a>
                </button>
                <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="delete" onclick="deleteUser(\'' . $email . '\')">
                                    <a href="deleteUser.php?deleteUserID=' . $UserID . '&role=' . $role . '">Delete</a>    
                </button>
                
            </td>
        </tr>';
    }
    

}
?>
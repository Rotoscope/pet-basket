
<!-- 
This page contains functions or JSON data structures 
NEEDED BY MORE THAN ONE PAGE !
-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<script type="text/javascript">

    // REMOVE THE LINE BELOW, AND BOOTSTRAP DROPDOWNS WON'T DROP DOWN
    $('.dropdown-toggle').dropdown();

    //console.log("start");
    var petBasket = [];
    var SHELL_USERNAME = '<?php echo USER; ?>';
    var user = '<?php echo isset($_SESSION['user']) ? $_SESSION['user'] : ''; ?>';

    if (user !== undefined && user !== '') {
        //throw "exit";
        var basketJsonString = <?php echo isset($_SESSION['user']) ? PetBasketController::myPetBasket($_SESSION['user'], 'json') : '[]'; ?>;
        petBasket = JSON.parse(basketJsonString);
        //throw "exit";
        makePetBasketItems(petBasket);
    } else {
        console.log("no user logged in");
    }

    // return to a particular tab/page after a full request
    var context = '<?php echo isset($get['context']) ? $get['context'] : null; ?>';

    // execute a pagejump
    var pagejump = '<?php echo isset($get['pagejump']) ? $get['pagejump'] : null; ?>';
    if (pagejump !== null)
        window.location.hash = pagejump;

    var numPerPage = 2;
    var page = 1;
    var pageLabel = 1;
    var defaultPath = '#page_';

    $('#nextPageButton').click(function () {
        //get up to date last page value
        var lastPage = $("#totalPages").val();

        console.log("current page: " + pageLabel);
        console.log("last page: " + lastPage);

        //determine if it is the lastpage or not
        //update values and scroll to correct location
        if (page <= (lastPage - numPerPage)) {
            page += numPerPage;
            pageLabel++;
            var path;
            var $target = null;
            path = defaultPath + page;
            $target = $(path);

            $('html, body').animate({
                'scrollTop': $target.offset().top - 70
            }, 450, 'swing', function () {
                window.location.hash = $target;
            });

            $('#pageNumber').html(pageLabel);
        }
    });

    $('#previousPageButton').click(function () {
        var lastPage = $("#totalPages").val();
        console.log("current page: " + pageLabel);
        console.log("last page: " + lastPage);
        if (page >= (numPerPage + 1)) {
            page -= numPerPage;
            pageLabel--;
            var path;
            var $target;
            if (page === 1) {
                path = '#page_0';
                $target = $(path);
            }
            else {
                path = defaultPath + page;
                $target = $(path);
            }

            $('html, body').animate({
                'scrollTop': $target.offset().top - 70
            }, 450, 'swing', function () {
                window.location.hash = $target;
            });

            $('#pageNumber').html(pageLabel);
        }
    });

    function sendMessage(data, callback) {
        $.ajax({
            type: "POST",
            url: '/~' + SHELL_USERNAME + '/index.php/PetBasket/sendMessage',
            data: data,
            success: callback,
            dataType: 'json'
        });
    }

    /**
     * Fetch info about the user who posted a particular pet
     */
    function getPosterInfo(petId, callbackFunction) {
        $.ajax({
            type: "GET",
            url: '/~' + SHELL_USERNAME + '/index.php/PetBasket/getPosterInfo?petId=' + petId,
            success: callbackFunction
        });
    }

    /**
     * Add a pet to the Pet Basket
     */
    function addToBasket(data) {
        if (getPetInBasketById(data.petId) === false) {
            $.ajax({
                type: "POST",
                url: '/~' + SHELL_USERNAME + '/index.php/PetBasket/addToBasket',
                data: data,
                success: function (resp) {
                    //console.log(resp);
                    if (resp.pet !== undefined) {
                        var pet = JSON.parse(resp.pet);
                        petBasket.pets.push(pet);
                        makePetBasketItem(pet);
                    }
                },
                dataType: 'json'
            });
        }
    }

    /*
     * Fetch the Pet object in a pet basket by pet id
     * @param int petId      the id of the
     * @returns Pet object or false if pet not found
     */
    function getPetInBasketById(petId) {
        console.log("getPetInBasketById:");
        console.log(petId);
        console.log(petBasket.pets);
        if (petBasket.pets !== undefined) {
            for (var i = 0; i < petBasket.pets.length; i++) {
                console.log(petBasket.pets[i].id + " =? " + petId);
                if (petBasket.pets[i].id == petId)
                    return petBasket.pets[i];
            }
        }
        return false;
    }

    /**
     * Remove a pet from the Pet Basket
     */
    function removeFromBasket(data) {
        $.ajax({
            type: "POST",
            url: '/~' + SHELL_USERNAME + '/index.php/PetBasket/removeFromBasket',
            data: data,
            success: function (resp) {
                if (resp.petId !== undefined) {
                    //console.log($('#petBasketItem_' + resp.petId));
                    $('#petBasketItem_' + resp.petId).remove();
                }
            },
            dataType: 'json'
        });
    }

    /**
     * Make Pet Basket Modal rows
     * @var petBasket         javascript object representation of a Basket
     */
    function makePetBasketItems(petBasket) {
        if (petBasket.pets !== undefined) {
            for (var i = 0; i < petBasket.pets.length; i++) {
                //console.log("pet in petBasket:");
                //console.log(petBasket.pets[i]);
                // make item and append to basket
                var pet = petBasket.pets[i];
                makePetBasketItem(pet);
                $('#addToBasketButton_' + pet.id).html('Added to basket');
            }
        }
    }

    /**
     * Build and append a Pet Basket Modal row
     * @var obj  pet javascript object representation of a Pet       
     */
    //<button id="contactPosterButton" type="button" class="btn btn-lrg btn-info fr" data-toggle="modal" data-target="#$modalTarget" data-user="$msgData">Contact the owner</button>
    function makePetBasketItem(pet) {
        console.log("make pet basket");
        var item = $('<div/>').attr('id', 'petBasketItem_' + pet.id).attr('class', 'row panel')
                .append($('<div/>').attr('class', 'col-md-3')
                        .append($('<img/>').attr('src', '/~' + SHELL_USERNAME + '/index.php/PetBasket/media?media=' + encodeURI(pet.images[0].thumbnails.sm.fileName))))
                .append($('<div/>').attr('class', 'col-xs-5')
                        .append($('<h5/>').html(pet.name).attr('class', 'petBasketModalPetName'))
                        .append($('<p/>').html(pet.description)))
                .append($('<div/>').attr('class', 'col-xs-2')
                        .append($('<a/>').attr('type', 'button')
                                         .attr('class', 'btn btn-primary m-bottom-10 contact')
                                         .attr('data-toggle', 'modal')
                                         .attr('data-target', '#contactPosterModal')
                                         .attr('data-user', user + '#' + pet.id)
                                         .html('Contact the owner'))
                        .append($('<a/>').attr('type', 'submit').attr('class', 'btn btn-default')
                        .attr('href', '/~' + SHELL_USERNAME + '/index.php/PetBasket/details?id=' + pet.id)
                        .html('Detail')))
                .append($('<div/>').attr('class', 'col-xs-2')
                        .append($('<button/>').attr('type', 'button').attr('class', 'close').attr('aria-label', 'Remove')
                                .html(
                                        $('<span/>').attr('aria-hidden', "true").html("&times;")).click(function () {
                            removePetBasketItem(this);
                        })));
        $('#petBasketContent').append(item);
    }



    /* When the "Contact the owner" button is clicked, populate the modal input fields with the data needed to send a message:
     * 1. The user id of the user sending the messsage
     * 2. The user id of the user who posted the pet for adoption
     * 3. The pet id of the pet which is the subject of the message
     * */
    $('#contactPosterModal').on('show.bs.modal', function (event) {
        console.log('Contact the owner button clicked');
        var button = $(event.relatedTarget); // Button that triggered the modal
        var senderData = button.data('user'); // Extract info from data-* attributes
        console.log("sender data: ");
        console.log(senderData);
        var parts = senderData.split('#');
        if (parts[0] !== undefined && parts[1] !== undefined) {
            var userId = parts[0];
            var petId = parts[1];
            getPosterInfo(petId, function (resp) {
                console.log(resp);
                var posterInfo = JSON.parse(resp);
                if (posterInfo.userId !== undefined && posterInfo.userName !== undefined) {
                    $('#contactPosterModalNameField')
                            .attr('data-senderId', userId)
                            .attr('data-recipientId', posterInfo.userId)
                            .attr('data-petId', petId)
                            .val(posterInfo.userName);
                }
            });
        }

    });
    $('#contactPosterModal').on('hide.bs.modal', function (event) {
        $('#contactPosterModalMessageNotification').html('');
        $('#contactPosterModalMessageField').html('');
        $('#contactPosterModalNameField').html('');
    });

    // Create and send a message to a pet Poster from a logged in user
    $('#contactPosterModalSubmitButton').click(function () {
        console.log("submit message");
        var senderId = $('#contactPosterModalNameField').attr('data-senderId');
        var recipientId = $('#contactPosterModalNameField').attr('data-recipientId');
        var petId = $('#contactPosterModalNameField').attr('data-petId');
        var message = $('#contactPosterModalMessageField').val();
        console.log("Message Data: ");
        var envelope = {
            senderId: senderId,
            recipientId: recipientId,
            petId: petId,
            message: message
        };
        //console.log(envelope);
        var callback = function (data, textStatus, jqXHR) {
            console.log("Message Transmission Result:");
            console.log(data);
            console.log(textStatus);
            console.log(jqXHR);
            if (data !== undefined) {
                //console.log(res);
                $('#contactPosterModalMessageNotification').html('Message Sent');
            } else {
                alert("Message not sent");
            }
        };
        sendMessage(envelope, callback);

    });

    console.log($('#addToBasket'));
    $('.addToBasketButton').click(function () {
        console.log('add to basket');
        if (user == '') {
            console.log('no user logged in');
            $('#login').modal('show');
            return;
        }
        var data = $(this).attr('data-addToBasket');
        console.log("Add to basket data >>");
        console.log(data);
        if (data !== '') {
            addToBasket(JSON.parse(data));
            $(this).html('Added to basket');
        }
    });


    /**
     * Remove a pet basket entry from the database and modal
     * @returns 1 if removed, 0 otherwise
     */
    var removePetBasketItem = function (context) {
        var petId = $(context).parent().parent().attr('id').split('_')[1];
        var postData = {userId: user, petId: petId};
        removeFromBasket(postData);
    }

    /*
     * Populate the breed selector
     * @var selectorId  the target selector to populate with breed names
     * @var species     json object with breed lists as properties, eg breeds.dog, breeds.cat, etc
     * @var selectedBreed    string to compare against breed types, if a match is found the selected attribute will be added to the option with the value true 
     */
    function populateBreedSelector(selectorId, species, selectedBreed) {
        /*
         console.log("populate breeds...");
         console.log("selectorId: " + selectorId);
         console.log("species: " + species);
         console.log("selected: " + selected);
         */
        var dropdown = $("#" + selectorId);
        dropdown.empty() //clear the dropdown of any previous values
        //dropdown.append($('<option/>'));
        console.log(breeds);
        console.log(species);

        if (breeds[species] !== undefined) {
            for (var i = 0; i < breeds[species].length; i++) {
                var option = $('<option/>', {text: breeds[species][i]});
                if (breeds[species][i] === selectedBreed)
                    option.attr("selected", true);
                //console.log(option);
                //throw "exit";
                dropdown.append(option);
            }
        }
    }

    /*
     * Populate the age selector
     * @var selectorId  the target selector to populate with breed names
     * @var ages        an array of age interval objects, each age interval object has string interval label, float age min and float age max
     * @var selected    string to compare against age labels. a match will set that label's 'selected' option attribute to true 
     * ex. ages ->      [{label:"0-5 years old","min":0,"max":5},{..}]
     */
    function populateAgeSelector(selectorId, ages, selected) {
        var dropdown = $("#" + selectorId);
        //dropdown.empty() //clear the dropdown of any previous values
        //dropdown.append($('<option/>'));
        for (var i = 0; i < ages.length; i++) {
            var option = $('<option/>', {text: ages[i].label, val: JSON.stringify(ages[i])});
            if (ages[i].label === selected)
                option.attr("selected", true);
            dropdown.append(option);
        }
    }
    //console.log('ages');
    var ages = [
        {label: "0-3 months old", min: 0, max: 0.25},
        {label: "3-6 months old", min: 0.25, max: .5},
        {label: "6-9 months old", min: .5, max: .75},
        {label: "9-12 months old", min: .75, max: 1.0},
        {label: "1-5 years old", min: 1.0, max: 5.0},
        {label: "5-9 years old", min: 5.0, max: 9.0},
        {label: "9-13 years old", min: 9.0, max: 13.0},
        {label: "13+ years old", min: 13.0, max: 1000}
    ];

    var breeds = {
        Dog:
                [
                    "All",
                    "Affenpinscher",
                    "Afghan Hound",
                    "Aidi",
                    "Airedale Terrier",
                    "Akbash Dog",
                    "Alano Español",
                    "Alaskan Klee Kai",
                    "Alaskan Malamute",
                    "Alpine Dachsbracke",
                    "Alpine Spaniel",
                    "American Bulldog",
                    "American Cocker Spaniel",
                    "American Eskimo Dog",
                    "American Foxhound",
                    "American Hairless Terrier",
                    "American Pit Bull Terrier",
                    "American Staffordshire Terrier",
                    "American Water Spaniel",
                    "Anglo-Français de Petite Vénerie",
                    "Appenzeller Sennenhund",
                    "Ariege Pointer",
                    "Ariegeois",
                    "Armant",
                    "Armenian Gampr dog",
                    "Artois Hound",
                    "Australian Cattle Dog",
                    "Australian Kelpie",
                    "Australian Shepherd",
                    "Australian Silky Terrier",
                    "Australian Stumpy Tail Cattle Dog",
                    "Australian Terrier",
                    "Azawakh",
                    "Bakharwal Dog",
                    "Barbet",
                    "Basenji",
                    "Basque Shepherd Dog",
                    "Basset Artésien Normand",
                    "Basset Bleu de Gascogne",
                    "Basset Fauve de Bretagne",
                    "Basset Hound",
                    "Bavarian Mountain Hound",
                    "Beagle",
                    "Beagle-Harrier",
                    "Bearded Collie",
                    "Beauceron",
                    "Bedlington Terrier",
                    "Belgian Shepherd Dog (Groenendael)",
                    "Belgian Shepherd Dog (Laekenois)",
                    "Belgian Shepherd Dog (Malinois)",
                    "Bergamasco Shepherd",
                    "Berger Blanc Suisse",
                    "Berger Picard",
                    "Berner Laufhund",
                    "Bernese Mountain Dog",
                    "Billy",
                    "Black and Tan Coonhound",
                    "Black and Tan Virginia Foxhound",
                    "Black Norwegian Elkhound",
                    "Black Russian Terrier",
                    "Bloodhound",
                    "Blue Lacy",
                    "Blue Paul Terrier",
                    "Boerboel",
                    "Bohemian Shepherd",
                    "Bolognese",
                    "Border Collie",
                    "Border Terrier",
                    "Borzoi",
                    "Boston Terrier",
                    "Bouvier des Ardennes",
                    "Bouvier des Flandres",
                    "Boxer",
                    "Boykin Spaniel",
                    "Bracco Italiano",
                    "Braque d'Auvergne",
                    "Braque du Bourbonnais",
                    "Braque du Puy",
                    "Braque Francais",
                    "Braque Saint-Germain",
                    "Brazilian Terrier",
                    "Briard",
                    "Briquet Griffon Vendéen",
                    "Brittany",
                    "Broholmer",
                    "Bruno Jura Hound",
                    "Bucovina Shepherd Dog",
                    "Bull and Terrier",
                    "Bull Terrier (Miniature)",
                    "Bull Terrier",
                    "Bulldog",
                    "Bullenbeisser",
                    "Bullmastiff",
                    "Bully Kutta",
                    "Burgos Pointer",
                    "Cairn Terrier",
                    "Canaan Dog",
                    "Canadian Eskimo Dog",
                    "Cane Corso",
                    "Cardigan Welsh Corgi",
                    "Carolina Dog",
                    "Carpathian Shepherd Dog",
                    "Catahoula Cur",
                    "Catalan Sheepdog",
                    "Caucasian Shepherd Dog",
                    "Cavalier King Charles Spaniel",
                    "Central Asian Shepherd Dog",
                    "Cesky Fousek",
                    "Cesky Terrier",
                    "Chesapeake Bay Retriever",
                    "Chien Français Blanc et Noir",
                    "Chien Français Blanc et Orange",
                    "Chien Français Tricolore",
                    "Chien-gris",
                    "Chihuahua",
                    "Chilean Fox Terrier",
                    "Chinese Chongqing Dog",
                    "Chinese Crested Dog",
                    "Chinese Imperial Dog",
                    "Chinook",
                    "Chippiparai",
                    "Chow Chow",
                    "Cierny Sery",
                    "Cimarrón Uruguayo",
                    "Cirneco dell'Etna",
                    "Clumber Spaniel",
                    "Combai",
                    "Cordoba Fighting Dog",
                    "Coton de Tulear",
                    "Cretan Hound",
                    "Croatian Sheepdog",
                    "Cumberland Sheepdog",
                    "Curly Coated Retriever",
                    "Cursinu",
                    "Cão da Serra de Aires",
                    "Cão de Castro Laboreiro",
                    "Cão Fila de São Miguel",
                    "Dachshund",
                    "Dalmatian",
                    "Dandie Dinmont Terrier",
                    "Danish Swedish Farmdog",
                    "Deutsche Bracke",
                    "Doberman Pinscher",
                    "Dogo Argentino",
                    "Dogo Cubano",
                    "Dogue de Bordeaux",
                    "Drentse Patrijshond",
                    "Drever",
                    "Dunker",
                    "Dutch Shepherd Dog",
                    "Dutch Smoushond",
                    "East Siberian Laika",
                    "East-European Shepherd",
                    "Elo",
                    "English Cocker Spaniel",
                    "English Foxhound",
                    "English Mastiff",
                    "English Setter",
                    "English Shepherd",
                    "English Springer Spaniel",
                    "English Toy Terrier (Black &amp; Tan)",
                    "English Water Spaniel",
                    "English White Terrier",
                    "Entlebucher Mountain Dog",
                    "Estonian Hound",
                    "Estrela Mountain Dog",
                    "Eurasier",
                    "Field Spaniel",
                    "Fila Brasileiro",
                    "Finnish Hound",
                    "Finnish Lapphund",
                    "Finnish Spitz",
                    "Flat-Coated Retriever",
                    "Formosan Mountain Dog",
                    "Fox Terrier (Smooth)",
                    "French Bulldog",
                    "French Spaniel",
                    "Galgo Español",
                    "Gascon Saintongeois",
                    "German Longhaired Pointer",
                    "German Pinscher",
                    "German Shorthaired Pointer",
                    "German Spaniel",
                    "German Spitz",
                    "German Wirehaired Pointer",
                    "Giant Schnauzer",
                    "Glen of Imaal Terrier",
                    "Golden Retriever",
                    "Gordon Setter",
                    "Gran Mastín de Borínquen",
                    "Grand Anglo-Français Blanc et Noir",
                    "Grand Anglo-Français Blanc et Orange",
                    "Grand Anglo-Français Tricolore",
                    "Grand Basset Griffon Vendéen",
                    "Grand Bleu de Gascogne",
                    "Grand Griffon Vendéen",
                    "Great Dane",
                    "Great Pyrenees",
                    "Greater Swiss Mountain Dog",
                    "Greek Harehound",
                    "Greenland Dog",
                    "Greyhound",
                    "Griffon Bleu de Gascogne",
                    "Griffon Bruxellois",
                    "Griffon Fauve de Bretagne",
                    "Griffon Nivernais",
                    "Hamiltonstövare",
                    "Hanover Hound",
                    "Hare Indian Dog",
                    "Harrier",
                    "Havanese",
                    "Hawaiian Poi Dog",
                    "Himalayan Sheepdog",
                    "Hokkaido",
                    "Hovawart",
                    "Huntaway",
                    "Hygenhund",
                    "Ibizan Hound",
                    "Icelandic Sheepdog",
                    "Indian pariah dog",
                    "Indian Spitz",
                    "Irish Red and White Setter",
                    "Irish Setter",
                    "Irish Terrier",
                    "Irish Water Spaniel",
                    "Irish Wolfhound",
                    "Istrian Coarse-haired Hound",
                    "Istrian Shorthaired Hound",
                    "Italian Greyhound",
                    "Jack Russell Terrier",
                    "Jagdterrier",
                    "Jämthund",
                    "Kai Ken",
                    "Kaikadi",
                    "Kanni",
                    "Karelian Bear Dog",
                    "Karst Shepherd",
                    "Keeshond",
                    "Kerry Beagle",
                    "Kerry Blue Terrier",
                    "King Charles Spaniel",
                    "King Shepherd",
                    "Kintamani",
                    "Kishu",
                    "Komondor",
                    "Kooikerhondje",
                    "Koolie",
                    "Korean Jindo Dog",
                    "Kromfohrländer",
                    "Kumaon Mastiff",
                    "Kurī",
                    "Kuvasz",
                    "Kyi-Leo",
                    "Labrador Husky",
                    "Labrador Retriever",
                    "Lagotto Romagnolo",
                    "Lakeland Terrier",
                    "Lancashire Heeler",
                    "Landseer",
                    "Lapponian Herder",
                    "Large Münsterländer",
                    "Leonberger",
                    "Lhasa Apso",
                    "Lithuanian Hound",
                    "Longhaired Whippet",
                    "Löwchen",
                    "Mahratta Greyhound",
                    "Maltese",
                    "Manchester Terrier",
                    "Maremma Sheepdog",
                    "McNab",
                    "Mexican Hairless Dog",
                    "Miniature American Shepherd",
                    "Miniature Australian Shepherd",
                    "Miniature Fox Terrier",
                    "Miniature Pinscher",
                    "Miniature Schnauzer",
                    "Miniature Shar Pei",
                    "Molossus",
                    "Montenegrin Mountain Hound",
                    "Moscow Watchdog",
                    "Moscow Water Dog",
                    "Mountain Cur",
                    "Mucuchies",
                    "Mudhol Hound",
                    "Mudi",
                    "Neapolitan Mastiff",
                    "New Zealand Heading Dog",
                    "Newfoundland",
                    "Norfolk Spaniel",
                    "Norfolk Terrier",
                    "Norrbottenspets",
                    "North Country Beagle",
                    "Northern Inuit Dog",
                    "Norwegian Buhund",
                    "Norwegian Elkhound",
                    "Norwegian Lundehund",
                    "Norwich Terrier",
                    "Old Croatian Sighthound",
                    "Old Danish Pointer",
                    "Old English Sheepdog",
                    "Old English Terrier",
                    "Old German Shepherd Dog",
                    "Olde English Bulldogge",
                    "Other",
                    "Otterhound",
                    "Pachon Navarro",
                    "Paisley Terrier",
                    "Pandikona",
                    "Papillon",
                    "Parson Russell Terrier",
                    "Patterdale Terrier",
                    "Pekingese",
                    "Pembroke Welsh Corgi",
                    "Perro de Presa Canario",
                    "Perro de Presa Mallorquin",
                    "Peruvian Hairless Dog",
                    "Petit Basset Griffon Vendéen",
                    "Petit Bleu de Gascogne",
                    "Phalène",
                    "Pharaoh Hound",
                    "Phu Quoc ridgeback dog",
                    "Picardy Spaniel",
                    "Plott Hound",
                    "Podenco Canario",
                    "Pointer (dog breed)",
                    "Polish Greyhound",
                    "Polish Hound",
                    "Polish Hunting Dog",
                    "Polish Lowland Sheepdog",
                    "Polish Tatra Sheepdog",
                    "Pomeranian",
                    "Pont-Audemer Spaniel",
                    "Poodle",
                    "Porcelaine",
                    "Portuguese Podengo",
                    "Portuguese Pointer",
                    "Portuguese Water Dog",
                    "Posavac Hound",
                    "Pražský Krysařík",
                    "Pudelpointer",
                    "Pug",
                    "Puli",
                    "Pumi",
                    "Pungsan Dog",
                    "Pyrenean Mastiff",
                    "Pyrenean Shepherd",
                    "Rafeiro do Alentejo",
                    "Rajapalayam",
                    "Rampur Greyhound",
                    "Rastreador Brasileiro",
                    "Rat Terrier",
                    "Ratonero Bodeguero Andaluz",
                    "Redbone Coonhound",
                    "Rhodesian Ridgeback",
                    "Rottweiler",
                    "Rough Collie",
                    "Russell Terrier",
                    "Russian Spaniel",
                    "Russian tracker",
                    "Russo-European Laika",
                    "Sabueso Español",
                    "Saint-Usuge Spaniel",
                    "Sakhalin Husky",
                    "Saluki",
                    "Samoyed",
                    "Sapsali",
                    "Schapendoes",
                    "Schillerstövare",
                    "Schipperke",
                    "Schweizer Laufhund",
                    "Schweizerischer Niederlaufhund",
                    "Scotch Collie",
                    "Scottish Deerhound",
                    "Scottish Terrier",
                    "Sealyham Terrier",
                    "Segugio Italiano",
                    "Seppala Siberian Sleddog",
                    "Serbian Hound",
                    "Serbian Tricolour Hound",
                    "Shar Pei",
                    "Shetland Sheepdog",
                    "Shiba Inu",
                    "Shih Tzu",
                    "Shikoku",
                    "Shiloh Shepherd Dog",
                    "Siberian Husky",
                    "Silken Windhound",
                    "Sinhala Hound",
                    "Skye Terrier",
                    "Sloughi",
                    "Slovak Cuvac",
                    "Slovakian Rough-haired Pointer",
                    "Small Greek Domestic Dog",
                    "Small Münsterländer",
                    "Smooth Collie",
                    "South Russian Ovcharka",
                    "Southern Hound",
                    "Spanish Mastiff",
                    "Spanish Water Dog",
                    "Spinone Italiano",
                    "Sporting Lucas Terrier",
                    "St. Bernard",
                    "St. John's water dog",
                    "Stabyhoun",
                    "Staffordshire Bull Terrier",
                    "Standard Schnauzer",
                    "Stephens Cur",
                    "Styrian Coarse-haired Hound",
                    "Sussex Spaniel",
                    "Swedish Lapphund",
                    "Swedish Vallhund",
                    "Tahltan Bear Dog",
                    "Taigan",
                    "Talbot",
                    "Tamaskan Dog",
                    "Teddy Roosevelt Terrier",
                    "Telomian",
                    "Tenterfield Terrier",
                    "Thai Bangkaew Dog",
                    "Thai Ridgeback",
                    "Tibetan Mastiff",
                    "Tibetan Spaniel",
                    "Tibetan Terrier",
                    "Tornjak",
                    "Tosa",
                    "Toy Bulldog",
                    "Toy Fox Terrier",
                    "Toy Manchester Terrier",
                    "Toy Trawler Spaniel",
                    "Transylvanian Hound",
                    "Treeing Cur",
                    "Treeing Walker Coonhound",
                    "Trigg Hound",
                    "Tweed Water Spaniel",
                    "Tyrolean Hound",
                    "Vizsla",
                    "Volpino Italiano",
                    "Weimaraner",
                    "Welsh Sheepdog",
                    "Welsh Springer Spaniel",
                    "Welsh Terrier",
                    "West Highland White Terrier",
                    "West Siberian Laika",
                    "Westphalian Dachsbracke",
                    "Wetterhoun",
                    "Whippet",
                    "White Shepherd",
                    "Wire Fox Terrier",
                    "Wirehaired Pointing Griffon",
                    "Wirehaired Vizsla",
                    "Yorkshire Terrier",
                    "Šarplaninac"
                ],
        Cat:
                [
                    "All",
                    "British Shorthair",
                    "Burmese",
                    "Chartreux",
                    "Cornish Rex",
                    "Cymric",
                    "Devon Rex",
                    "Egyptian Mau",
                    "Exotic Shorthair",
                    "Havana Brown",
                    "Himalayan",
                    "Japanese Bobtail",
                    "Korat",
                    "Maine Coon",
                    "Manx",
                    "Norwegian Forest Cat",
                    "Ocicat",
                    "Other",
                    "Persian",
                    "Pixie Bob",
                    "Ragdoll",
                    "Russian Blue",
                    "Scottish Fol",
                    "Selkirk Rex",
                    "Siamese",
                    "Siberian",
                    "Snowshoe",
                    "Somali",
                    "Sphynx",
                    "Tonkinese",
                    "Turkish Angora",
                    "Turkish Van"

                ],
        Other: ["Other"]
    };

</script>
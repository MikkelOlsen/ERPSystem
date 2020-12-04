For at kunne bruge dette ERP system, kræver det først at du har XAMPP installeret.</br>
XAMPP - https://www.apachefriends.org/index.html </br></br>

Når du har installeret XAMPP (husk installations mappen!!) med både Apache, PhP oh MySQL, så skal du navigere i din browser navigere til "localhost/phpmyadmin".</br>
Når du er her, så skal du importere sql filen der ligger i projektet (det er vigtigt at din database kommer til at hedde "erp", ellers skal du selv rette det i database.config.php filen.</br>
[![phpmyadmin.png](https://i.postimg.cc/G2D7Fx7V/phpmyadmin.png)](https://postimg.cc/629fwnNf)

Når det er gjordt så skal du tage resten af mappen/projektet og ligge det i din xampp mappe og så inde under "htdocs" mappen. </br>Her opretter du en mappe som du kan kalde hvad du lyster, bare husk på at hvad end du kalder den er hvad du kommer til at skulle skrive i din url adresse. </br>
Lig det resterende kode ind i den nye mappe.

Du er næsten færdig nu, du skal blot starte xampp control panel og starte din apache og mysql service.

Du kan nu tilgå sitet ved at skrive "localhost/[navnet på din mappe her]".


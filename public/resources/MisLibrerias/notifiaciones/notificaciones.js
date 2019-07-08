function notificarme()
{
    if ( !window.Notification) {
        console.log('Este navegador no Soporta NT')
        return;
    }
    if (Notification.permission === 'granted') {
        new Notification('Hola, a todos - granted');
    } else if (Notification.permission !== 'denied' || Notification.permission === 'default') {
        Notification.requestPermission( function(permission){

            console.log(permission);

            if (permission === 'granted') {
                new Notification('Hola, a todos - pregunta');
            }
        });
    } else {

    }
}

notificarme();

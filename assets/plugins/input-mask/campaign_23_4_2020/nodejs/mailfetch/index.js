const express = require('express');
//var rootCas = require('ssl-root-cas/latest').create();

//require('https').globalAgent.options.ca = rootCas;
const ImapClient = require('emailjs-imap-client').default;
const app = express();

process.env.NODE_TLS_REJECT_UNAUTHORIZED = "0";

const client = new ImapClient('imap.gmail.com', 993, {
    auth: {
        user: 'annas.elh@gmail.com',
        pass: 'lmlatyigascdizko'
    },
    //useSecureTransport: true,
    //ignoreTLS: true
})

client.onerror = (error) => {
    console.log(error);
}

client.connect().then( () => {
    /* ready to roll */
    client.search('INBOX', { unseen: true }, { byUid: true }).then((messages) => {
        messages.forEach((uid) => console.log('Message ' + uid + ' is unread'));
    });
})

app.listen(3000)
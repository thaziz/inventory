#!/usr/bin/env node
var Imap = require('imap'),inspect = require('util').inspect;
const resolve = require('path').resolve
const replyParser = require('node-email-reply-parser');
const Iconv = require('iconv-lite').Iconv;
const moment = require('moment');
const htmlToText = require('html-to-text');
const MailParser = require('mailparser').MailParser;
const db = require('./config/database');
const Sequelize = require('sequelize');
//const EmailModel = require('./models/v_email')
//const EmailCustomerModel = require('./models/v_email_customer')
//const EmailReplyModel = require('./models/v_email_reply')
const TicketHistoryModel = require('./models/v_ticket_history')
const NotifModel = require('./models/v_notif')
const logger = require('./config/logger');
let parser = null;

var fs = require('fs'), fileStream;

var imap = new Imap({
    user: 'tabanan@c-icare.cc',//'annas.elh@gmail.com',
    password: 'p@ssw0rd123',
    host: 'mail.c-icare.cc',
    port: 993,
    tls: true,
    tlsOptions: { rejectUnauthorized: false }
});

function openInbox(cb) {
    imap.openBox('INBOX', false, cb);
}

imap.once('ready', () => {
    openInbox( (err, box) => {
        if (err) throw err;
        //setInterval(() => {
        imap.search(['\Unseen'], function (err, results) {
                if (err) {
                    console.log('you are already up to date');
                }
                if (!results || results.length){
		    imap.setFlags(results, ['\\Seen'], function(err) {});
                    var f = imap.fetch(results, { bodies: '', markSeen: true });
                    f.on('message', function (msg, seqno) {
                        var path = 'assets/covaid';
                        var emailData = {};
                        var prefix = '(#' + seqno + ') ';
                        emailData['email_id'] = seqno;
                        msg.on('body', function (stream, info) {2
                            //console.log(prefix + 'Body');
                            //stream.pipe(fs.createWriteStream('msg-' + seqno + '-body.txt'));
                            parser = new MailParser({ Iconv });
                            let attach = '';
                            parser.on('headers', headers=>{
                                //console.log(headers);
                                emailData['subject'] = headers.get('subject') !== undefined ? headers.get('subject').split(" ").join(" ") : '';
                                emailData['email_from'] = headers.get('from').value[0].address.toLowerCase();
                                emailData['email_to'] = headers.get('to').value[0].address.toLowerCase();
                                
                                //console.log(moment(headers.get('date')).format('YYYY-MM-DD HH:mm:ss'));
                                emailData['time'] = headers.get('date');
                                path = path+'/'+moment(headers.get('date')).format('YYYY/MM/DD');
                            })
                            parser.on('data', data=>{
                                if (data.type === 'text') {
                                    //console.log(data.text);
                                    if (data.text!==undefined){
                                        emailData['content'] = replyParser(data.text.replace(/CAUTION(.*)sender and know the content is safe./g, ''), true);
                                        emailData['content_as_is'] = data.text;
                                    }else{
                                        emailData['content'] = htmlToText.fromString(replyParser(data.html.replace(/<style.*<\/style>/g, ''), true), false);
                                        emailData['content'] = emailData['content'].replace(/(Kanmo Retail Group\nGedung Menara Era 8th Floor\nJl Senen Raya No. 135 - 137)(.*)([\s\S] *)/g, '')
                                        emailData['content_as_is'] = data.html;
                                    }
                                    emailData['content'] = emailData['content'].split(' ').join(' ');
                                    
                                }
                                if (data.type === 'attachment') {
                                    let filename = data.filename;
                                    filename = filename.split('/');
                                    filename = filename[filename.length-1];
                                    var filepath = path + '/' + seqno + '/' + filename
                                    attach = attach + '\n' + '<a href="https://103.129.205.39/covaid/'+filepath+'">'+filename+'</a>';
                                    emailData['attachment'] = emailData['attachment'] == undefined ? filepath : emailData['attachment']+','+filepath;
                                    //console.log(filepath);
                                    fs.mkdirSync('/var/www/html/covaid/' + path + '/' + seqno, { recursive: true });
                                    data.content.pipe(fs.createWriteStream(('/var/www/html/covaid/'+filepath)));
                                    data.content.on('end', () => data.release());
                                }
                            })
                            parser.on('end', ()=>{
                                emailData.content = emailData.content +'\n'+ attach;
                                emailData.content_as_is = emailData.content_as_is +'\n'+ attach;
                                
                                if (emailData.subject.toLowerCase().trim().substr(0,3) === 're:' || emailData.subject.toLowerCase().trim().substr(0, 4) === 'bls:') {
                                    if (emailData.subject.toLowerCase().includes('ticket id') && emailData.subject.toLowerCase().includes('membutuhkan respon anda segera')) {
                                        
                                        insertToHistoryTicket(emailData);
                                    } /*else if (emailData.subject.toLowerCase().includes('ticket id') && !emailData.subject.toLowerCase().includes('membutuhkan respon anda segera')) {
                                        insertToEmailTicket(emailData);
                                    } else {
                                        insertToEmailReply(emailData);
                                    }*/
                                }/* else if (emailData.subject.toLowerCase().substr(0.14) !== 'undeliverable:') {
                                    checkEmailExist(emailData.email_id, emailData.email_from, 'v_email', (response) => { 
                                        if (parseInt(response) === 0) {
                                            EmailModel.create({
                                                email_id: emailData.email_id,
                                                open_date: emailData.time,
                                                subject: emailData.subject,
                                                content: emailData.content,
                                                content_as_is: emailData.content_as_is,
                                                attachment: emailData.attachment,
                                                email: emailData.email_from,
                                                //type: 'KANMO',//(data.email_to == 'support@kanmogroup.com' || data.email_to == 'support@kanmoretail.com') ? 'KANMO' : (emailData.email_to == 'club.indonesia@nespresso.co.id' ? 'NESPRESSO' : ''),
                                                is_read: 0,
                                            })
                                                .then(email => { console.log('Saved email success') })
                                                .catch(err => {console.log(err);logger.error(new Date()+': Error on insert email line 133  '+err + ' ' + JSON.stringify(emailData))})
                                        }
                                    })
                                }*/
                                //console.log(emailData);
                            })
                            stream.pipe(parser);
                        });
                        msg.once('attributes', function (attrs) {
                            //console.log(prefix + 'Attributes: %s', inspect(attrs, false, 8));
                        });
                        msg.once('end', function () {
                            console.log(prefix + 'Finished');
                        });
                    });
                    f.once('error', function (err) {
                        logger.error('Fetch error: ' + err);
                    });
                    f.once('end', function () {
                        console.log('Done fetching all messages!');
                    });
                } else {
                    console.log('you are already up to date');
                }
            });
        //}, 100);
    });
});

imap.on('mail', (num)=>{
    logger.info(new Date() + ' Got new email: ' + num);
    openInbox((err, box) => {
        if (err) throw err;
        //setInterval(() => {
        imap.search(['\Unseen'], function (err, results) {
            if (err) {
                console.log('you are already up to date');
            }
            if (!results || results.length) {
		imap.setFlags(results, ['\\Seen'], function(err) {})
                var f = imap.fetch(results, { bodies: '', markSeen: true });
                f.on('message', function (msg, seqno) {
                    var path = 'assets/covaid';
                    var emailData = {};
                    var prefix = '(#' + seqno + ') ';
                    emailData['email_id'] = seqno;
                    msg.on('body', function (stream, info) {
                        2
                        //console.log(prefix + 'Body');
                        //stream.pipe(fs.createWriteStream('msg-' + seqno + '-body.txt'));
                        parser = new MailParser({ Iconv });
                        let attach = '';
                        parser.on('headers', headers => {
                            emailData['subject'] = headers.get('subject')!==undefined?headers.get('subject').split(" ").join(" "):'';
                            emailData['email_from'] = headers.get('from').value[0].address.toLowerCase();
                            emailData['email_to'] = headers.get('to').value[0].address.toLowerCase();
                            
                            //console.log(moment(headers.get('date')).format('YYYY-MM-DD HH:mm:ss'));
                            emailData['time'] = headers.get('date');
                            path = path+'/'+moment(headers.get('date')).format('YYYY/MM/DD');
                        })
                        parser.on('data', data => {
                            if (data.type === 'text') {
                                //console.log(data.text);
                                if (data.text !== undefined) {
                                    emailData['content'] = replyParser(data.text.replace(/CAUTION(.*)sender and know the content is safe./g, ''), true);
                                    emailData['content_as_is'] = data.text;
                                } else {
                                    emailData['content'] = htmlToText.fromString(replyParser(data.html.replace(/<style.*<\/style>/g, ''), true), false);
                                    emailData['content'] = emailData['content'].replace(/(Kanmo Retail Group\nGedung Menara Era 8th Floor\nJl Senen Raya No. 135 - 137)(.*)([\s\S] *)/g,'')
                                    emailData['content_as_is'] = data.html;
                                }
                                emailData['content'] = emailData['content'].split(' ').join(' ');
                            }
                            if (data.type === 'attachment') {
                                let filename = data.filename;
                                filename = filename.split('/');
                                filename = filename[filename.length - 1];
                                var filepath = path + '/' + seqno + '/' + filename
                                attach = attach + '\n' + '<a href="https://103.129.205.39/covaid/' + filepath + '">' + filename + '</a>';
                                emailData['attachment'] = emailData['attachment'] == undefined ? filepath : emailData['attachment'] + ',' + filepath;
                                //console.log(filepath);
                                fs.mkdirSync('/var/www/html/covaid/' + path + '/' + seqno, { recursive: true });
                                data.content.pipe(fs.createWriteStream(('/var/www/html/covaid/' + filepath)));
                                data.content.on('end', () => data.release());
                            }
                        })
                        parser.on('end', () => {
                            emailData.content = emailData.content + '\n' + attach;
                            emailData.content_as_is = emailData.content_as_is + '\n' + attach;
                            
                            if (emailData.subject.toLowerCase().trim().substr(0, 3) === 're:' || emailData.subject.toLowerCase().trim().substr(0, 4) === 'bls:') {
                                if (emailData.subject.toLowerCase().includes('ticket id') && emailData.subject.toLowerCase().includes('membutuhkan respon anda segera')) {
                                    
                                    insertToHistoryTicket(emailData);
                                }/* else if (emailData.subject.toLowerCase().includes('ticket id') && !emailData.subject.toLowerCase().includes('membutuhkan respon anda segera')) {
                                    insertToEmailTicket(emailData);
                                } else {
                                    insertToEmailReply(emailData);
                                }*/
                            }/* else if (emailData.subject.toLowerCase().substr(0.14) !== 'undeliverable:') {
                                checkEmailExist(emailData.email_id, emailData.email_from, 'v_email', (response) => {
                                    //console.log('Check result ' + response)
                                    if (parseInt(response) === 0) {
                                        EmailModel.create({
                                            email_id: emailData.email_id,
                                            open_date: emailData.time,
                                            subject: emailData.subject,
                                            content: emailData.content,
                                            content_as_is: emailData.content_as_is,
                                            attachment: emailData.attachment,
                                            email: emailData.email_from,
                                            type: 'KANMO',//(data.email_to == 'support@kanmogroup.com' || data.email_to == 'support@kanmoretail.com') ? 'KANMO' : (emailData.email_to == 'club.indonesia@nespresso.co.id' ? 'NESPRESSO' : ''),
                                            is_read: 0,
                                        })
                                            .then(email => { console.log('Saved email success') })
                                            .catch(err => logger.error(new Date() + ': Error on insert email line 266  ' +err + ' ' + emailData.email_from))
                                    }
                                })
                            }*/
                            //console.log(emailData);
                        })
                        stream.pipe(parser);
                    });
                    msg.once('attributes', function (attrs) {
                        //console.log(prefix + 'Attributes: %s', inspect(attrs, false, 8));
                    });
                    msg.once('end', function () {
                        console.log(prefix + 'Finished');
                    });
                });
                f.once('error', function (err) {
                    logger.error('Fetch error: ' + err);
                });
                f.once('end', function () {
                    console.log('Done fetching all messages!');
                });
            } else {
                console.log('you are already up to date');
            }
        });
        //}, 100);
    });
})

imap.connect();

/*function insertToEmailReply(data) {
    checkEmailExist(data.email_id, data.email_from, 'v_email_reply', (response) => { 
        //console.log('Check result ' + response)
        if (parseInt(response) === 0) {
            db.query(`SELECT id, email_id, type FROM v_email WHERE subject = '` + data.subject.split(" ").join(" ").substr(3) + `' and email ='${data.email_from}'`)
                .then(result => {
                    if (result != null) {
                        EmailReplyModel.create({
                            parent_id: result[0][0].id,
                            email_id: data.email_id,
                            time: data.time,
                            content: data.content,
                            subject: data.subject,
                            content_as_is: data.content_as_is,
                            email_from: data.email_from,
                            email_to: data.email_to,
                            type: result[0][0].type,
                            attachment: data.attachment,
                            is_read: 0,
                        })
                            .then(email => { console.log('Saved email reply success') })
                            .catch(err => logger.error(new Date() + ': Error on insert email reply line 316  ' +err + ' ' + data.email_from))
                    } else {
                        EmailModel.create({
                            email_id: data.email_id,
                            open_date: data.time,
                            subject: data.subject,
                            content: data.content,
                            content_as_is: data.content_as_is,
                            email: data.email_from,
                            attachment: data.attachment,
                            type: 'KANMO',//(data.email_to == 'support@kanmogroup.com' || data.email_to == 'support@kanmoretail.com') ? 'KANMO' : (data.email_to == 'club.indonesia@nespresso.co.id' ? 'NESPRESSO' : ''),
                            is_read: 0,
                        })
                            .then(email => { console.log('Saved email success') })
                            .catch(err => logger.error(new Date() + ': Error on insert email line 330  ' + err + ' ' + data.email_from))
                    }
                })
                .catch(err => {
                    EmailModel.create({
                        email_id: data.email_id,
                        open_date: data.time,
                        subject: data.subject,
                        content: data.content,
                        content_as_is: data.content_as_is,
                        email: data.email_from,
                        attachment: data.attachment,
                        type: 'KANMO',//(data.email_to == 'support@kanmogroup.com' || data.email_to == 'support@kanmoretail.com') ? 'KANMO' : (data.email_to == 'club.indonesia@nespresso.co.id' ? 'NESPRESSO' : ''),
                        is_read: 0,
                    })
                        .then(email => { console.log('Saved email success') })
                        .catch(err => logger.error(new Date() + ': Error on insert email line 330  ' +err + ' ' + data.email_from))
                });
        } else {
            console.log('email exist')
        }
    })
}

function insertToEmailTicket(data) {
    checkEmailExist(data.email_id, data.email_from, 'v_email_customer', (response) => { 
        if (parseInt(response) === 0){
            db.query(`SELECT id, open_by, ticket_id, main_category, subject, content, category, sub_category, type, curr_assign, email, cus_fname FROM v_ticket WHERE ticket_id = '` + data.subject.substr(data.subject.toLowerCase().indexOf('ticket id')+11, 14) + `'`)
                .then(result => {
                    if (result != null) {
                        //if (result[0][0].email === data.email_from) {
                            EmailCustomerModel.create({
                                ticket_id: result[0][0].id,
                                email_id: data.email_id,
                                time: data.time,
                                content: data.content,
                                subject: data.subject,
                                content_as_is: data.content_as_is,
                                email: data.email_from,
                                attachment: data.attachment,
                                is_read: 0,
                            })
                                .then(email => { console.log('Saved email ticket success') })
                                .catch(err => logger.error(new Date() + ':   Error on insert email ticket ' +err + ' ' + data.email_from))
                        
                    } else {
                        EmailModel.create({
                            email_id: data.email_id,
                            open_date: data.time,
                            subject: data.subject,
                            content: data.content,
                            content_as_is: data.content_as_is,
                            email: data.email_from,
                            attachment: data.attachment,
                            type: 'KANMO',
                            is_read: 0,
                        })
                            .then(email => { console.log('Saved email success') })
                            .catch(err => logger.error(new Date() + ': Error on insert email line 384 ' + err + ' ' + data.email_from))
                    }
                })
                .catch(err => {
                    EmailModel.create({
                        email_id: data.email_id,
                        open_date: data.time,
                        subject: data.subject,
                        content: data.content,
                        content_as_is: data.content_as_is,
                        email: data.email_from,
                        attachment: data.attachment,
                        type: 'KANMO',
                        is_read: 0,
                    })
                        .then(email => { console.log('Saved email success') })
                        .catch(err => logger.error(new Date() + ': Error on insert email line 384 ' +err + ' ' + data.email_from))
                });
        } else {
            console.log('email exist')
        }

    })
}*/

function insertToHistoryTicket(data) {
    checkEmailExist(data.email_id, data.email_from, 'v_ticket_history', (response) => { 
        if (parseInt(response) === 0) {
            db.query(`SELECT id, open_by, ticket_id, subject, content, category, sub_category, curr_assign, cus_name FROM v_ticket WHERE ticket_id = '` + data.subject.substr(data.subject.toLowerCase().indexOf('ticket id')+10, 14) + `'`)
                .then(result => {
                    if (result != null) {
                        TicketHistoryModel.create({
                            ticket_id: result[0][0].id,
                            email_id: data.email_id,
                            username: data.email_from,
                            time: data.time,
                            activity: data.content,
                            email_content: data.content_as_is,
                            email: data.email_from,
                        })
                            .then(email => { console.log('Saved ticket history success '+email) })
                            .catch(err => logger.error(new Date() + ': Error on insert history ticket line 408  ' +err + ' ' + data.email_from))

                        NotifModel.create({
                            user_ext: result[0][0].open_by,
                            title: `<strong>${data.email_from}</strong> reply your email on a ticket`,
                            url: `menu=ticket_data&action=detail&id=${result[0][0].ticket_id}`,
                            time: data.time,
                            ticket_id: result[0][0].ticket_id,
                            type: 'message',
                        })
                            .then(email => { console.log('Saved email ticket success') })
                            .catch(err => logger.error(new Date() + ': Error on insert notif on line 419  ' +err + ' ' + data.email_from))
                    } /*else {
                        EmailModel.create({
                            email_id: data.email_id,
                            open_date: data.time,
                            subject: data.subject,
                            content: data.content,
                            content_as_is: data.content_as_is,
                            email: data.email_from,
                            attachment: data.attachment,
                            type: 'KANMO',//(data.email_to == 'support@kanmogroup.com' || data.email_to == 'support@kanmoretail.com') ? 'KANMO' : (data.email_to == 'club.indonesia@nespresso.co.id' ? 'NESPRESSO' : ''),
                            is_read: 0,
                        })
                            .then(email => { console.log('Saved email success') })
                            .catch(err => logger.error(new Date() + ': Error on insert email line 433  ' + err + ' ' + data.email_from))
                    }*/
                })
                .catch(err => {
                    /*EmailModel.create({
                        email_id: data.email_id,
                        open_date: data.time,
                        subject: data.subject,
                        content: data.content,
                        content_as_is: data.content_as_is,
                        email: data.email_from,
                        attachment: data.attachment,
                        type: 'KANMO',//(data.email_to == 'support@kanmogroup.com' || data.email_to == 'support@kanmoretail.com') ? 'KANMO' : (data.email_to == 'club.indonesia@nespresso.co.id' ? 'NESPRESSO' : ''),
                        is_read: 0,
                    })
                        .then(email => { console.log('Saved email success') })*/
                        /*.catch(err => */logger.error(new Date() + ': Error on insert email line 433  ' +err + ' ' + data.email_from)//)
                });
        } else {
            console.log('content: ' + data.content)
            console.log('email exist '+data.email_id)
        }
    })
}

function checkEmailExist(email_id, email_from, table, callback) {
    filter = `email_id = ${email_id} AND email = '${email_from}'`;
    switch (table) {
        case 'v_email_reply':
            filter = `email_id = ${email_id} AND email_from = '${email_from}'`;
            break;
        case 'v_ticket_history':
            filter = `email_id = ${email_id} AND username = '${email_from}'`;
            break;
        default:
            filter = `email_id = ${email_id} AND email = '${email_from}'`;
            break;
    }

    db.query(`SELECT COUNT(*) as total FROM ${table} WHERE ${filter}`)
        .then(result => {
            console.log('total result ' + result[0][0].total);
            callback(result[0][0].total);
        })
        .catch(err => {
            console.log(err)
            logger.error(err)
            callback(false);
        });
}


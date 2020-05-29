const Sequelize = require('sequelize');
const db = require('../config/database');

const EmailCustomer = db.define('v_email_customer', {
    ticket_id: {
        type: Sequelize.INTEGER,
        allowNull: false,
    },
    email_id: {
        type: Sequelize.INTEGER,
        allowNull: false,
    },
    email_to: {
        type: Sequelize.STRING,
        allowNull: true,
    },
    subject: {
        type: Sequelize.TEXT,
        allowNull: true,
    },
    cc: {
        type: Sequelize.STRING,
        allowNull: true,
    },
    bcc: {
        type: Sequelize.STRING,
        allowNull: true,
    },
    email: {
        type: Sequelize.STRING,
        allowNull: true,
    },
    time: {
        type: Sequelize.DATE,
        allowNull: false,
    },
    content: {
        type: Sequelize.TEXT,
        allowNull: true,
    },
    content_as_is: {
        type: Sequelize.TEXT,
        allowNull: true,
    },
    attachment: {
        type: Sequelize.STRING,
        allowNull: true,
    },
    is_read: {
        type: Sequelize.INTEGER,
        allowNull: true,
    }
},{
    timestamps: false
});


module.exports = EmailCustomer;

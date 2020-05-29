const Sequelize = require('sequelize');
const db = require('../config/database');

const EmailTicketHistory = db.define('v_ticket_history', {
    history_id: {
        type: Sequelize.INTEGER,
        primaryKey: true
    },
    ticket_id: {
        type: Sequelize.INTEGER,
        allowNull: false,
    },
    email_id: {
        type: Sequelize.INTEGER,
        allowNull: false,
    },
    username: {
        type: Sequelize.STRING,
        allowNull: true,
    },
    activity: {
        type: Sequelize.TEXT,
        allowNull: true,
    },
    time: {
        type: Sequelize.DATE,
        allowNull: false,
    },
    email_content: {
        type: Sequelize.TEXT,
        allowNull: true,
    }
}, {
    timestamps: false
});


module.exports = EmailTicketHistory;

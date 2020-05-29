
const Sequelize = require('sequelize');
const db = new Sequelize('covaid_center', 'root', 'dut4_MEDIA', {
    host: 'localhost',
    dialect: 'mysql',
    dialectOptions: {
        //useUTC: false, //for reading from database
        dateStrings: true,
        typeCast: true
    },
    logging: false,
    hooks: {
        beforeDefine: (columns, model) => {
            model.tableName = `${model.name.singular}`
        }
    },
    define: {
        underscored: true,
        freezeTableName: true, //use singular table name
        //timestamps: false,  // I do not want timestamp fields by default
    },
    pool: {
        max: 5,
        min: 0,
        acquire: 30000,
        idle: 10000
    },
    timezone: "+07:00"
});

/*const db = {};

db.Sequelize = Sequelize;
db.sequelize = sequelize;

//Models/tables
/*db.user = require('../models/user')(sequelize, Sequelize);
db.role = require('../models/role')(sequelize, Sequelize);
db.menu = require('../models/menu')(sequelize, Sequelize);
db.menu_rule = require('../models/menu_rule')(sequelize, Sequelize);

db.user.belongsTo(db.role, { foreignKey: 'role_id' });
db.role.hasMany(db.menu_rule, { foreignKey: 'role_id'});*/
//db.menu.belongsToMany(db.role, {through:db.menu_rule, foreignKey: 'menu_id'});

module.exports = db;
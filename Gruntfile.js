module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    // Javascript Tasks
    jshint: {
      files: 'src/js/*.js',
      options: {
        // options here to override JSHint defaults
        globals: {
          jQuery: true,
          console: true,
          module: true,
          document: true
        }
      }
    },
    uglify: {
      options: {
        banner: '/*\n <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> \n*/\n'
      },
      build: {
        files: {
          'dist/scripts.min.js': 'src/js/*.js'
        }
      }
    },
    // CSS Tasks
    sass: {
      build: {
        files: {
          'src/css/build-style.css': 'src/scss/style.scss'
        }
      }
    },
    cssmin: {
      options: {
        banner: '/*\n <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> \n*/\n'
      },
      build: {
        files: {
          'dist/style.min.css': 'src/css/build-style.css'
        }
      }
    },
    
    watch: {
      
      // for stylesheets, watch css and scss files 
      // only run scss and cssmin stylesheets: 
      files: ['src/**/*.css', 'src/**/*.scss'], 
      tasks: ['sass', 'cssmin'],

      // for scripts, run jshint and uglify 
      scripts: { 
        files: 'src/**/*.js' 
        tasks: ['jshint', 'uglify'] 
      } 
    }

  });

  // Load the plugin that provides the "uglify" task, etc.
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task(s).
  grunt.registerTask('default', ['uglify', 'jshint', 'cssmin', 'sass', 'watch']);

};
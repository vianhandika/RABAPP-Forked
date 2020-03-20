<template>
  <v-app class="grey lighten-4">
    <v-container>
      <v-toolbar dark color="light-blue accent-3">
        <v-toolbar-title>RAB</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>

        <v-text-field
          v-model="search"
          append-icon="search"
          label="Search"
          single-line
          hide-details
          style="width: 5px"
        >
        </v-text-field>
      
        <div class="flex-grow-1"></div>
        <v-dialog v-model="dialog" width="750px" max-height="200px">  
          <template v-slot:activator="{ on }">
            <v-btn color="green darken-1" elevation="8" rounded dark v-on="on" @click="dialog8=true;reset()">New</v-btn>
          </template>
          <v-card color="">

            <v-toolbar dark color="light-blue accent-4">
              <v-btn icon dark @click="dialog = false; dialog7=false;dialog8=false">
                <v-icon>close</v-icon>
              </v-btn>
              <v-toolbar-title v-if="dialog8">New RAB</v-toolbar-title>
              <v-toolbar-title v-if="dialog7">Edit RAB</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-toolbar-items v-if="dialog8">
                <v-btn dark text @click="addAllItem" :loading="loading">Save</v-btn>
              </v-toolbar-items>
              <v-toolbar-items v-if="dialog7">
                <v-btn dark text @click="updateItem(rab.id_rab)" :loading="loading">Save</v-btn>
              </v-toolbar-items>
            </v-toolbar>

            <template>
              <v-card>
                <v-tabs 
                  v-model="tab"
                  color="white"
                  background-color="light-blue accent-3"
                >
                  <v-tab ripple href='#tab-1'>
                    <v-icon left>payment</v-icon>
                    Data
                  </v-tab>
                  <v-tab ripple href='#tab-2'>
                    <v-icon>home</v-icon>
                    Building
                  </v-tab>
                  <v-tab ripple href='#tab-3'>
                    <v-icon left>group_work</v-icon>
                    Floor
                  </v-tab>
                  <v-tab ripple href='#tab-4'>
                    <v-icon left>work</v-icon>
                    Task Group
                  </v-tab>
                  <v-tab ripple href='#tab-5'>
                    <v-icon left>payment</v-icon>
                    AHS 
                  </v-tab>
                  <!-- Fom RAB awal -->
                  <v-tab-item value='tab-1'>
                    <v-form ref="form"> 
                      <v-card-text>
                        <v-layout>
                          <v-text-field
                            v-model="rab.kode"
                            label="ID"
                            readonly
                          >
                          </v-text-field>
                        </v-layout>

                        <v-layout v-if="dialog8">
                          <v-select
                            v-model="rab.id_project"
                            label="Project"
                            item-text="project"
                            item-value="id_project" 
                            :items="filterProject"
                            :return-object="false"
                          ></v-select>
                        </v-layout>
                        
                        <v-layout v-if="dialog7">
                          <v-select
                            v-model="rab.id_project"
                            label="Project"
                            :items="project"
                            item-text="project"
                            item-value="id_project" 
                            :return-object="false"
                            readonly
                          ></v-select>
                        </v-layout>

                        <v-layout>
                          <v-text-field
                            v-model="rab.desc"
                            label="Note"
                            >
                          </v-text-field>
                        </v-layout>

                        <v-layout>
                          <v-text-field
                            v-model="rab.total_rab"
                            label="Nominal"
                            readonly
                          ></v-text-field>
                        </v-layout>
                      </v-card-text>
                    </v-form>
                  </v-tab-item>
                  <!-- Form Structure -->
                  <v-tab-item value='tab-2'>
                    <!-- <v-layout>
                      <v-card-title>Detail Building</v-card-title>
                      <VBtn
                        color="light-blue darken-4"
                        dark
                        @click="filterStructures();tambahS=true"
                        elevation="3"
                      >
                      Add  
                      </VBtn>
                    </v-layout> 
                    <v-flex class="text-md-center" sm12> 
                      <v-Card
                        v-for="(detail_structure,index) in Structure"
                        :key="index"
                        style="margin-top: 4px"
                        elevation="8"
                        > 
                          <v-card-title>
                          <v-btn 
                            icon
                            color="red"
                            dark @click="dialogdeletestructure=true;itemDelete(detail_structure)"
                            >
                            <v-icon>remove_circle</v-icon>
                          </v-btn>
                          <template>
                            <v-edit-dialog
                              @save="editstructure(index,detail_structure)"
                              @cancel="cancel" 
                              lazy
                              large
                            >
                            <v-flex>
                              <v-select
                                label="Building" 
                                class="pa-1"
                                v-model="detail_structure.id_structure"
                                item-text="structure"
                                item-value="id_structure"
                                :items="detailStructure"
                                readonly 
                              ></v-select>
                            </v-flex>
                              <template v-slot:input>
                                <v-flex
                                  @click="itemstructure(index,detail_structure)"
                                  v-if="!editList"
                                >
                                  <v-select
                                    label="Building" 
                                    v-model="detail_structure.id_structure"
                                    item-text="structure"
                                    item-value="id_structure"
                                    :items="detailStructure"
                                  ></v-select>
                                </v-flex>
                                <v-flex v-if="editList">
                                  <v-select
                                    label="Building" 
                                    v-model="structure_data.id_structure"
                                    item-text="name"
                                    item-value="id_structure"
                                    :items="filterStructure"
                                  ></v-select>
                                </v-flex>
                              </template>
                            </v-edit-dialog>
                          </template>
                        </v-card-title>
                      </v-card>
                    </v-flex>
                    
                    <v-data-table
                      :headers="headers_building_details"
                      :items="detailStructure"
                      class=""
                    >
                    <template v-slot:top>
                      <v-toolbar>
                        <v-toolbar-title>Detail Building</v-toolbar-title>
                        <v-divider
                          class="mx-4"
                          inset
                          vertical
                        ></v-divider>
                        <VBtn
                          color="light-blue darken-4"
                          dark
                          @click="filterStructures();tambahS=true"
                          elevation="3"
                        >
                        Add  
                        </VBtn>
                      </v-toolbar>
                      <v-container>
                        <v-layout v-if="tambahS">
                          <v-flex class="text-md-center" sm12 mt-2>
                            <v-card elevation="3"> 
                              <v-card-title>
                              <v-btn 
                                icon
                                color="red"
                                dark @click="tambahS=false"
                                >
                                <v-icon>remove_circle</v-icon>
                              </v-btn>
                              <v-btn 
                                icon
                                color="green"
                                dark @click="addstructure();tambahS=false"
                                >
                                <v-icon>add_circle</v-icon>
                              </v-btn>
                                <v-flex xs5>
                                  <v-select
                                    v-model="structure_data.id_structure"
                                    :items="filterStructure"
                                    label="Building"
                                    item-text="name"
                                    item-value="id_structure"
                                  >
                                  </v-select>
                                </v-flex>
                              </v-card-title>
                            </v-card>
                          </v-flex>
                        </v-layout>
                      </v-container>
                    </template>

                    <template v-slot:item.action="{ item }">
                      <v-btn
                        color="red"
                        @click="dialogdeletestructure=true;itemDelete(item)"
                        icon
                      >
                      <v-icon>delete</v-icon>
                      </v-btn>
                    </template>
                    </v-data-table> -->
                    <v-form>
                      <v-card-text>
                        <VBtn
                          color="light-blue darken-4"
                          fab dark
                          @click="filterStructures();tambahS=true"
                        >
                        Add  
                        </VBtn>

                        <v-flex class="text-md-center" sm12> 
                          <v-Card
                            v-for="(detail_structure,index) in Structure"
                            :key="index"
                            style="margin-top: 4px"
                            elevation="8"
                            > 
                              <v-card-title>
                              <v-btn 
                                icon
                                color="red"
                                dark @click="dialogdeletestructure=true;itemDelete(detail_structure)"
                                >
                                <v-icon>remove_circle</v-icon>
                              </v-btn>
                              <template>
                                <v-edit-dialog
                                  @save="editstructure(index,detail_structure)"
                                  @cancel="cancel" 
                                  lazy
                                  large
                                >
                                <v-flex>
                                  <v-select
                                    label="Building" 
                                    class="pa-1"
                                    v-model="detail_structure.id_structure"
                                    item-text="structure"
                                    item-value="id_structure"
                                    :items="detailStructure"
                                    readonly 
                                  ></v-select>
                                </v-flex>
                                  <template v-slot:input>
                                    <v-flex
                                      @click="itemstructure(index,detail_structure)"
                                      v-if="!editList"
                                    >
                                      <v-select
                                        label="Building" 
                                        v-model="detail_structure.id_structure"
                                        item-text="structure"
                                        item-value="id_structure"
                                        :items="detailStructure"
                                      ></v-select>
                                    </v-flex>
                                    <v-flex v-if="editList">
                                      <v-select
                                        label="Building" 
                                        v-model="structure_data.id_structure"
                                        item-text="name"
                                        item-value="id_structure"
                                        :items="filterStructure"
                                      ></v-select>
                                    </v-flex>
                                  </template>
                                </v-edit-dialog>
                              </template>
                            </v-card-title>
                          </v-card>
                        </v-flex>

                        <v-layout v-if="tambahS">
                          <v-flex class="text-md-center" sm12 mt-2>
                            <v-card elevation="3"> 
                              <v-card-title>
                              <v-btn 
                                icon
                                color="red"
                                dark @click="tambahS=false"
                                >
                                <v-icon>remove_circle</v-icon>
                              </v-btn>
                              <v-btn 
                                icon
                                color="green"
                                dark @click="addstructure();tambahS=false"
                                >
                                <v-icon>add_circle</v-icon>
                              </v-btn>
                                <v-flex xs5>
                                  <v-select
                                    v-model="structure_data.id_structure"
                                    :items="filterStructure"
                                    label="Building"
                                    item-text="name"
                                    item-value="id_structure"
                                  >
                                  </v-select>
                                </v-flex>
                              </v-card-title>
                            </v-card>
                          </v-flex>
                        </v-layout>
                      </v-card-text>
                    </v-form>
                    <v-dialog v-model="dialogdeletestructure" max-width="290px">
                      <v-card>
                        <v-card-title class="headline">Confirmation</v-card-title>
                          <v-card-text>Are you sure want to delete this building?</v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="green darken-1" text @click="dialogdeletestructure = false; deletestructure(structure_data)">Yes</v-btn>
                          <v-btn color="red darken-1" text @click="dialogdeletestructure = false">No</v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>
                  </v-tab-item>
                  <!-- Form Floor -->
                  <v-tab-item value='tab-3'>
                    <v-data-table
                      :headers="headers_detail_building"
                      :items="detailStructure"
                      height="150px">

                      <template v-slot:top>
                        <v-toolbar>
                          <v-toolbar-title>Detail Building</v-toolbar-title>
                          <v-divider
                            class="mx-4"
                            inset
                            vertical
                          ></v-divider>
                        </v-toolbar>
                      </template>

                      <template v-slot:item.action="{ item }">
                        <v-tooltip bottom>
                          <template v-slot:activator="{ on }">
                            <v-btn 
                              icon
                              color="light-blue darken-4"
                              dark @click="tambahF=true;filterGroups(item)"
                              v-on="on"
                            >
                            <v-icon>add_box</v-icon>
                            </v-btn>
                          </template>
                          <span>Add Floor</span>
                        </v-tooltip>
                      </template>
                    </v-data-table>

                    <v-form>
                      <v-card-text>
                        <v-flex class="text-md-center" sm12>
                          <VCard
                            v-for="(detail_group,index) in Groups"
                            :key="index"
                            style="margin-top: 4px"
                            elevation="8"
                            > 
                              <v-card-title>
                              <v-btn 
                                icon
                                color="red"
                                dark @click="dialogdeletefloor=true;itemDelete(detail_group)"
                                >
                                <v-icon>remove_circle</v-icon>
                              </v-btn>
                              
                              <v-flex xs12 sm4 md4>
                                <v-select
                                  label="Building" 
                                  class="pa-1"
                                  v-model="detail_group.id_structure"
                                  item-text="structure"
                                  item-value="id_structure"
                                  :items="detailGroup"
                                  readonly 
                                ></v-select>
                              </v-flex>
                              <template>
                                <v-edit-dialog
                                  @save="editfloor(index,detail_group)"
                                  @cancel="cancel"
                                  lazy
                                  large
                                >
                                  <v-flex>
                                    <v-select
                                      label="Floor" 
                                      class="pa-1"
                                      v-model="detail_group.id_groups"
                                      :items="detailGroup"
                                      item-text="floor"
                                      item-value="id_groups"
                                      readonly
                                      >
                                    </v-select>
                                  </v-flex>
                                  <template v-slot:input>
                                    <v-flex 
                                      @click="itemfloor(index,detail_group)" 
                                      v-if="!editList"
                                    >
                                      <v-select
                                        label="Floor" 
                                        v-model="detail_group.id_groups"
                                        :items="detailGroup"
                                        item-text="floor"
                                        item-value="id_groups"
                                      ></v-select>
                                    </v-flex>
                                    <v-flex v-if="editList">
                                      <v-select
                                        label="Floor" 
                                        v-model="group_data.id_groups"
                                        item-text="name"
                                        item-value="id_group"
                                        :items="filterGroup"
                                      ></v-select>
                                    </v-flex>
                                  </template>
                                </v-edit-dialog>
                              </template>
                            </v-card-title>
                          </Vcard>
                        </v-flex>
                          
                        <v-layout v-if="tambahF">
                          <v-flex class="text-md-center" sm12 mt-2>
                            <VCard elevation="8"> 
                              <v-card-title>
                              <v-btn 
                                  icon
                                  color="red"
                                  dark @click="tambahF=false"
                                  >
                                  <v-icon>remove_circle</v-icon>
                              </v-btn>
                              <v-btn 
                                  icon
                                  color="green"
                                  dark @click="addfloor();tambahF=false"
                                  >
                                  <v-icon>add_circle</v-icon>
                              </v-btn>
                              <!-- buat pertama kali input data untuk addList -->
                                <v-flex xs12 sm4 md4>
                                  <v-select
                                    label="Building" 
                                    class="pa-1"
                                    v-model="structure_unit.id_structure"
                                    item-text="structure"
                                    item-value="id_structure"
                                    :items="detailStructure"
                                    readonly
                                  ></v-select>
                                </v-flex>
                                
                                <v-flex xs12 sm4 md4>
                                  <v-select
                                  label="Floor" 
                                  class="pa-1"
                                  v-model="group_data.id_groups"
                                  :items="filterGroup"
                                  item-text="name"
                                  item-value="id_group"
                                  required
                                  ></v-select>
                                </v-flex>

                                </v-card-title>
                            </Vcard>
                          </v-flex>
                        </v-layout>
                      </v-card-text>
                    </v-form>
                    <v-dialog v-model="dialogdeletefloor" max-width="290px">
                      <v-card>
                        <v-card-title class="headline">Confirmation</v-card-title>
                          <v-card-text>Are you sure want to delete this floor?</v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="green darken-1" text @click="dialogdeletefloor = false; deletefloor(group_data)">Yes</v-btn>
                          <v-btn color="red darken-1" text @click="dialogdeletefloor = false">No</v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>
                  </v-tab-item>
                  <!-- Form Type of Task -->
                  <v-tab-item value='tab-4'>
                    <v-layout>
                      <v-flex>
                        <v-data-table
                          :headers="headers_detail_floor"
                          :items="detailGroup"
                          height="150px">

                          <template v-slot:top>
                            <v-toolbar>
                              <v-toolbar-title>Detail Floor</v-toolbar-title>
                              <v-divider
                                class="mx-4"
                                inset
                                vertical
                              ></v-divider>
                            </v-toolbar>
                          </template>
                          
                          <template v-slot:item.action="{ item }">
                            <v-tooltip bottom>
                              <template v-slot:activator="{ on }">
                                <v-btn 
                                  icon
                                  color="light-blue darken-4"
                                  dark @click="tambahT=true;filterTaskGroups(item)"
                                  v-on="on"
                                >
                                <v-icon>add_box</v-icon>
                                </v-btn>
                              </template>
                              <span>Add Task Group</span>
                            </v-tooltip>
                          </template>
                        </v-data-table>
                      </v-flex>
                    </v-layout>

                    <v-form>
                      <v-card-text>
                      <v-flex class="text-md-center" sm12>
                        <VCard
                          v-for="(detail_task,index) in TaskSub"
                          :key="index"
                          style="margin-top: 4px"
                          elevation="8"
                          > 
                            <v-card-title>
                            <v-btn 
                                icon
                                color="red"
                                dark @click="dialogdeletetask=true;itemDelete(detail_task)"
                                >
                                <v-icon>remove_circle</v-icon>
                            </v-btn>
                            <!-- buat ditampilkan setelah di clik addList -->
                            <v-flex xs11 sm3 md3>
                              <v-select
                                label="Building" 
                                class="pa-1"
                                v-model="detail_task.id_structure"
                                item-text="structure"
                                item-value="id_structure"
                                :items="detailTask"
                                readonly
                              ></v-select>
                            </v-flex>

                            <v-flex xs11 sm3 md3>
                              <v-select
                                label="Floor" 
                                class="pa-1"
                                v-model="detail_task.id_groups"
                                item-text="floor"
                                item-value="id_groups"
                                :items="detailTask"
                                readonly 
                              ></v-select>
                            </v-flex>
                            <v-flex xs12 sm4 md4>
                              <template>
                                <v-edit-dialog
                                  @save="edittasksub(index,detail_task)"
                                  @cancel="cancel"
                                  lazy
                                  large
                                >
                                  <v-select
                                    label="Task Group" 
                                    class="pa-1"
                                    v-model="detail_task.id_sub"
                                    item-text="task"
                                    item-value="id_sub"
                                    :items="detailTask"
                                    readonly 
                                  ></v-select>
                                  <template v-slot:input>
                                    <v-flex 
                                      @click="itemtasksub(index,detail_task)" 
                                      v-if="!editList"
                                    >
                                      <v-select
                                        label="Task Group" 
                                        v-model="detail_task.id_sub"
                                        item-text="task"
                                        item-value="id_sub"
                                        :items="detailTask"
                                      ></v-select>
                                    </v-flex>
                                    <v-flex v-if="editList">
                                      <v-select
                                        label="Task Group" 
                                        v-model="tasksub_data.id_sub"
                                        item-text="name"
                                        item-value="id_sub"
                                        :items="filterTaskGroup"
                                      ></v-select>
                                    </v-flex>
                                  </template>
                                </v-edit-dialog>
                              </template>
                            </v-flex>
                          </v-card-title>
                        </Vcard>
                      </v-flex>
                        
                      <v-layout>
                        <v-layout v-if="tambahT">
                          <v-flex class="text-md-center" sm12 mt-2>
                            <VCard elevation="8"> 
                              <v-card-title>
                              <v-btn 
                                  icon
                                  color="red"
                                  dark @click="tambahT=false"
                              >
                              <v-icon>remove_circle</v-icon>
                              </v-btn>
                              <v-btn 
                                  icon
                                  color="green"
                                  dark @click="addtasksub();tambahT=false"
                                  >
                                  <v-icon>add_circle</v-icon>
                              </v-btn>
                              <v-flex xs11 sm3 md3>
                                <v-select
                                  label="Building" 
                                  class="pa-1"
                                  v-model="group_unit.id_structure"
                                  item-text="structure"
                                  item-value="id_structure"
                                  :items="detailGroup"
                                  readonly
                                ></v-select>
                              </v-flex>
                            
                              <v-flex xs11 sm3 md3>
                                <v-select
                                label="Floor" 
                                class="pa-1"
                                v-model="group_unit.id_groups"
                                :items="detailGroup"
                                item-text="floor"
                                item-value="id_groups"
                                readonly
                                ></v-select>
                              </v-flex>

                              <v-flex xs12 sm4 md4>
                                <v-select
                                label="Task Group" 
                                class="pa-1"
                                v-model="tasksub_data.id_sub"
                                item-text="name"
                                item-value="id_sub"
                                :items="filterTaskGroup"
                                required 
                                ></v-select>
                              </v-flex>
                              </v-card-title>
                            </Vcard>
                          </v-flex>
                        </v-layout>
                      </v-layout>
                      </v-card-text>
                    </v-form>
                    <v-dialog v-model="dialogdeletetask" max-width="290px">
                        <v-card>
                          <v-card-title class="headline">Confirmation</v-card-title>
                            <v-card-text>Are you sure want to delete this task group?</v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" text @click="dialogdeletetask = false; deletetasksub(tasksub_data)">Yes</v-btn>
                            <v-btn color="red darken-1" text @click="dialogdeletetask = false">No</v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>
                  </v-tab-item>
                  <!-- Form Detail -->
                  <v-tab-item value='tab-5'>
                    <v-flex>
                      <v-data-table
                        :headers="headers_detail_task"
                        :items="detailTask"
                        height="150px">

                        <template v-slot:top>
                          <v-toolbar>
                            <v-toolbar-title>Detail Task Group</v-toolbar-title>
                            <v-divider
                              class="mx-4"
                              inset
                              vertical
                            ></v-divider>
                          </v-toolbar>
                        </template>

                        <template v-slot:item.action="{ item }">
                          <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                              <v-btn 
                                icon
                                color="light-blue darken-4"
                                dark @click="filterAHS(item);tambah=true"
                                v-on="on"
                                >
                              <v-icon>add_box</v-icon>
                              </v-btn>
                            </template>
                            <span>Add AHS</span>
                          </v-tooltip>
                        </template>
                      </v-data-table>
                    </v-flex>

                    <v-card>
                      <v-form>
                        <v-card-text>
                          <v-layout v-if="tambah">
                            <v-flex class="text-md-center" sm12 mt-2>
                              <VCard elevation="8"> 
                                <v-card-title>
                                  <v-btn 
                                    icon
                                    color="red"
                                    dark @click="tambah=false"
                                    >
                                    <v-icon>remove_circle</v-icon>
                                  </v-btn>
                                  <v-btn 
                                    icon
                                    color="green"
                                    dark @click="addList()"
                                    >
                                    <v-icon>add_circle</v-icon>
                                  </v-btn>

                                  <v-flex xs11 sm3 md3>
                                    <v-select
                                      label="Building" 
                                      class="pa-1"
                                      v-model="tasksub_unit.id_structure"
                                      item-text="structure"
                                      item-value="id_structure"
                                      :items="detailTask"
                                      readonly 
                                    ></v-select>
                                  </v-flex>

                                  <v-flex xs11 sm3 md3>
                                    <v-select
                                      label="Floor" 
                                      class="pa-1"
                                      v-model="tasksub_unit.id_groups"
                                      item-text="floor"
                                      item-value="id_groups"
                                      :items="detailTask"
                                      readonly 
                                    ></v-select>
                                  </v-flex>

                                  <v-flex xs12 sm4 md4>
                                    <v-select
                                      label="Task Group" 
                                      class="pa-1"
                                      v-model="tasksub_unit.id_sub"
                                      item-text="task"
                                      item-value="id_sub"
                                      :items="detailTask"
                                      readonly 
                                    ></v-select>
                                  </v-flex>
                                  
                                  <v-flex xs12 sm4 md4>
                                    <v-select 
                                      label="AHS" 
                                      class="pa-1"
                                      v-model="AHS.id_ahs"
                                      item-text="name"
                                      item-value="id_ahs"
                                      :items="filterAHSAll"
                                      required 
                                      @input="detailCard=true;change();adjust()"
                                    ></v-select>
                                  </v-flex>

                                  <v-flex xs10 sm2 md2>
                                    <v-select
                                      label="HSP" 
                                      class="pa-1"
                                      v-model="AHS.id_ahs"
                                      item-text="total"
                                      item-value="id_ahs"
                                      :items="filterAHSAll"
                                      readonly
                                    ></v-select>
                                  </v-flex>

                                  <v-flex xs1 v-if="detailCard">
                                    <v-text-field
                                      v-model="ahs_lokal.volume"
                                      label="Volume"
                                      class="pa-1"
                                      @change="change();adjust()"
                                      type="number"
                                    >
                                    </v-text-field>
                                  </v-flex>

                                  <v-flex xs1 v-if="detailCard">
                                    <v-text-field
                                      v-model="ahs_lokal.adjustment"
                                      label="Adjustment"
                                      class="pa-1"
                                      @change="adjust"
                                      v-on:keyup.enter="adjustM=true;getMaterialDetails()"
                                      type="number"
                                    >
                                    </v-text-field>
                                  </v-flex>

                                  <v-flex xs10 sm2 md2 v-if="detailCard">
                                    <v-text-field
                                      v-model="ahs_lokal.HP"
                                      label="HP"
                                      class="pa-1"
                                      readonly
                                      type="number"
                                    >
                                    </v-text-field>
                                  </v-flex>

                                  <v-flex xs10 sm2 md2 v-if="detailCard">
                                    <v-text-field
                                      v-model="ahs_lokal.HP_Adjust"
                                      label="HP Adjustment"
                                      class="pa-1"
                                      readonly
                                      type="number"
                                    >
                                    </v-text-field>
                                  </v-flex>
                                </v-card-title>
                              </Vcard>
                            </v-flex>
                          </v-layout>
                          <v-flex class="text-md-center" sm12>
                            <VCard
                              v-for="(detail,index) in details"
                              :key="index"
                              style="margin-top: 4px"
                              elevation="8"
                            > 
                              <v-card-title>
                              <v-btn 
                                  icon
                                  color="red"
                                  dark @click="dialogdeletedetail=true;itemDelete(detail)"
                                  >
                                  <v-icon>remove_circle</v-icon>
                              </v-btn>

                              <v-flex xs11 sm3 md3>
                                <v-select
                                  label="Building" 
                                  class="pa-1"
                                  v-model="detail.id_structure"
                                  item-text="structure"
                                  item-value="id_structure"
                                  :items="detailDetails"
                                  readonly 
                                ></v-select>
                              </v-flex>

                              <v-flex xs11 sm3 md3>
                                <v-select
                                  label="Floor" 
                                  class="pa-1"
                                  v-model="detail.id_groups"
                                  item-text="floor"
                                  item-value="id_groups"
                                  :items="detailDetails"
                                  readonly 
                                ></v-select>
                              </v-flex>

                              <v-flex xs12 sm4 md4>
                                <v-select
                                  label="Task Group" 
                                  class="pa-1"
                                  v-model="detail.id_sub"
                                  item-text="task"
                                  item-value="id_sub"
                                  :items="detailDetails"
                                  readonly 
                                ></v-select>
                              </v-flex>

                              <template>
                                <v-edit-dialog 
                                  @save="editAHS(index,detail)"
                                  @cancel="cancel"
                                  large
                                  lazy
                                  persistent
                                >
                                  <v-flex>
                                    <v-select
                                      label="AHS" 
                                      class="pa-1"
                                      v-model="detail.id_ahs"
                                      item-text="name"
                                      item-value="id_ahs"
                                      :items="detailDetails"
                                      readonly 
                                    ></v-select>
                                  </v-flex>
                                  <template v-slot:input>
                                    <v-flex 
                                      @click="itemList(index,detail)"
                                      v-if="!editList"
                                    >
                                      <v-select
                                        label="AHS" 
                                        v-model="detail.id_ahs"
                                        item-text="name"
                                        item-value="id_ahs"
                                        :items="detailDetails"
                                      ></v-select>
                                    </v-flex>
                                    <v-flex v-if="editList">
                                      <v-select
                                        label="AHS" 
                                        v-model="ahs_lokal.id_ahs"
                                        item-text="name"
                                        item-value="id_ahs"
                                        :items="filterAHSAll"
                                      ></v-select>
                                    </v-flex>
                                  </template>
                                </v-edit-dialog>
                              </template>

                              <v-flex>
                                <v-text-field
                                  v-model="detail.HSP"
                                  label="HSP"
                                  class="pa-1"
                                  readonly
                                >
                                </v-text-field>
                              </v-flex>

                              <template>
                                <v-edit-dialog
                                  @save="editvolumeadjust(index,detail)"
                                  @cancel="cancel"
                                  large
                                  persistent
                                  lazy
                                >
                                <v-text-field
                                    v-model="detail.volume"
                                    label="Volume"
                                    class="pa-1"
                                    readonly
                                    type="number"
                                  >
                                  </v-text-field>
                                <template v-slot:input>
                                  <v-flex >
                                    <v-text-field
                                      v-model="detail.volume"
                                      label="Edit"
                                      single-line
                                      counter
                                      type="number"
                                      >
                                    </v-text-field>
                                  </v-flex>
                                </template>
                                </v-edit-dialog>
                              </template>
                            
                              <template>
                                <v-edit-dialog
                                  @save="editvolumeadjust(index,detail)"
                                  @cancel="cancel"
                                  large
                                  persistent
                                  lazy
                                >
                                <v-flex>
                                  <v-text-field
                                    v-model="detail.adjustment"
                                    label="Adjustment"
                                    class="pa-1"
                                    readonly
                                    type="number"
                                  >
                                  </v-text-field>
                                </v-flex>
                                <template v-slot:input>
                                  <v-flex>
                                    <v-text-field
                                      v-model="detail.adjustment"
                                      label="Edit"
                                      single-line
                                      counter
                                      type="number"
                                    >
                                    </v-text-field>
                                  </v-flex>
                                </template>
                                </v-edit-dialog>
                              </template>

                              <v-flex xs10 sm2 md2>
                                <v-text-field
                                  v-model="detail.HP"
                                  label="HP"
                                  class="pa-1"
                                  readonly
                                  type="number"
                                >
                                </v-text-field>
                              </v-flex>

                              <v-flex xs10 sm2 md2>
                                <v-text-field
                                  v-model="detail.HP_Adjust"
                                  label="HP Adjustment"
                                  class="pa-1"
                                  readonly
                                  type="number"
                                >
                                </v-text-field>
                              </v-flex>
                              </v-card-title>
                                <v-dialog v-model="dialogdeletedetail" max-width="290px">
                                  <v-card>
                                    <v-card-title class="headline">Confirmation</v-card-title>
                                      <v-card-text>Are you sure want to delete this detail task?</v-card-text>
                                    <v-card-actions>
                                      <v-spacer></v-spacer>
                                      <v-btn color="green darken-1" text @click="dialogdeletedetail = false; deleteList(ahs_lokal)">Yes</v-btn>
                                      <v-btn color="red darken-1" text @click="dialogdeletedetail = false">No</v-btn>
                                    </v-card-actions>
                                  </v-card>
                                </v-dialog>
                            </Vcard>
                          </v-flex>
                        </v-card-text>
                      </v-form>
                    </v-card>

                    <v-flex class="text-md-center" sm12 mt-2 v-if="adjustM">
                      <div>
                        <v-data-table
                          :headers="headers_filter_materials"
                          sortBy="status"
                          update: sort-desc
                          class="elevation-1"
                          :items="filterMaterialsAll"
                        >
                        <template v-slot:top>
                          <v-toolbar>
                            <v-toolbar-title>Detail Materials/Labor</v-toolbar-title>
                            <v-divider
                              class="mx-4"
                              inset
                              vertical
                            ></v-divider>
                            <v-btn color="blue" dark class="mb-2" @click="adjustM=false">Close</v-btn>
                          </v-toolbar>
                        </template>
                        </v-data-table>
                      </div>
                    </v-flex>
                  </v-tab-item>
                </v-tabs>
              </v-card>
            </template>
          </v-card>
        </v-dialog>
      </v-toolbar>
      
      <v-card elevation="10">
        <v-list-group v-for="data in filtered" :key="data.id_rab">
          <template v-slot:activator>
            <v-list-item-content>
              <v-layout>
                <v-flex xs3>
                  <div class="caption grey--text">ID RAB</div>
                  <div>{{ data.kode }}</div>
                </v-flex>
                <v-flex xs5>
                  <div class="caption grey--text">Project</div>
                  <div>{{ data.project }}</div>
                </v-flex>
                <v-flex xs5>
                  <div class="caption grey--text">Nominal</div>
                  <v-layout>
                    <div style="text-align:left;width:30px">Rp.</div>
                    <div style="text-align:right;width:140px">{{ Number(data.total).toLocaleString('id-ID') }}</div>  
                  </v-layout>
                </v-flex>
                <v-flex xs4>
                  <div class="caption grey--text">Description</div>
                  <div>{{ data.desc }}</div>
                </v-flex>
                <v-flex xs1>
                  <div class="caption grey--text">Actions</div>
                  <v-icon color="green" @click="itemEdit(data);dialog=true;dialog7=true;detailstructure=false">edit</v-icon>
                  <v-icon color="red" @click="itemDeleteRAB(data);dialog2=true;detailstructure=false">delete</v-icon>
                </v-flex>
              </v-layout>
            </v-list-item-content>
            <v-icon color="light-blue accent-3" @click="detailstructure=true">expand_more</v-icon>
          </template>
          <template v-if="detailstructure">
            <v-list-group v-for="structure in data.structure.data" :key="structure.id_structure_details">
              <template v-slot:activator>
                <v-list-item-content class="borderStructure">
                  <v-list-item-title class="marginBorder">{{ structure.structure }}</v-list-item-title>
                </v-list-item-content>
                <v-icon color="blue darken-3" @click="dialog3=true;itemDetail(structure)">delete</v-icon>
              </template>
              <!-- dialog delete structure -->
                <v-dialog v-model="dialog3" max-width="290px">
                  <v-card>
                    <v-card-title class="headline">Confirmation</v-card-title>
                      <v-card-text>Are you sure want to delete this building?</v-card-text>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn color="green darken-1" text @click="dialog3 = false; deleteStructureDetails(detail.id_structure_details)">Yes</v-btn>
                      <v-btn color="red darken-1" text @click="dialog3 = false">No</v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
              <!--  -->
              <template>
                <v-list-group v-for="group in structure.group.data" :key="group.id_group_details">
                  <template v-slot:activator>
                    <v-list-item-content class="borderFloor">
                      <v-list-item-title class="marginBorder">Lantai {{group.floor}}</v-list-item-title>
                    </v-list-item-content>
                    <v-icon color="light-blue accent-3" @click="dialog4=true;itemDetail(group)">delete</v-icon>
                  </template>
                  <!-- dialog delete floor -->
                    <v-dialog v-model="dialog4" max-width="290px">
                      <v-card>
                        <v-card-title class="headline">Confirmation</v-card-title>
                          <v-card-text>Are you sure want to delete this floor?</v-card-text>
                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="green darken-1" text @click="dialog4 = false; deleteGroupDetails(detail.id_group_details)">Yes</v-btn>
                          <v-btn color="red darken-1" text @click="dialog4 = false">No</v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>
                  <!--  -->
                  <v-list-group v-for="task in group.task_sub.data" :key="task.id_sub_details">
                    <template v-slot:activator>
                      <v-list-item-content class="borderTask">
                        <v-list-item-title class="marginBorder">Pekerjaan   {{task.task}}</v-list-item-title>
                      </v-list-item-content>
                      <v-icon color="light-blue lighten-2" @click="dialog5=true;itemDetail(task)">delete</v-icon>
                    </template>
                    <!-- dialog delete task group -->
                      <v-dialog v-model="dialog5" max-width="290px">
                        <v-card>
                          <v-card-title class="headline">Confirmation</v-card-title>
                            <v-card-text>Are you sure want to delete this task group?</v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" text @click="dialog5 = false; deleteTaskDetails(detail.id_sub_details)">Yes</v-btn>
                            <v-btn color="red darken-1" text @click="dialog5 = false">No</v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>
                    <!--  -->
                    <v-list-group v-for="detail_ahs in task.rab_details.data" :key="detail_ahs.id_ahs_lokal">
                      <template v-slot:activator>
                        <v-list-item-content class="borderDetail">
                          <v-layout class="marginBorder">
                            <v-flex xs4>
                              <div class="caption grey--text">Task</div>
                              <div>{{ detail_ahs.name }}</div>
                            </v-flex>
                            <v-flex xs2>
                              <div class="caption grey--text">Volume</div>
                              <div>{{ detail_ahs.volume }}</div>
                            </v-flex>
                            <v-flex xs2>
                              <div class="caption grey--text">Satuan</div>
                              <div>{{ detail_ahs.satuan }}</div>
                            </v-flex>
                            <v-flex xs4>
                              <div class="caption grey--text">HSP</div>
                              <v-layout>
                              <div style="text-align:left;width:25px">Rp.</div>
                              <div style="text-align:right;width:120px">{{ Number(detail_ahs.HSP).toLocaleString('id-ID') }}</div>
                              </v-layout>
                            </v-flex>
                            <v-flex xs2>
                              <div class="caption grey--text">Adjust</div>
                              <div >{{ detail_ahs.adjustment }}</div>
                            </v-flex>
                            <v-flex xs4>
                              <div class="caption grey--text">HP</div>
                              <v-layout>
                                <div style="text-align:left;width:25px">Rp.</div>
                                <div style="text-align:right;width:120px">{{ Number(detail_ahs.HP).toLocaleString('id-ID') }}</div>
                              </v-layout>
                            </v-flex>
                            <v-flex xs4>
                              <div class="caption grey--text">HP Adjust</div>
                              <v-layout>
                              <div style="text-align:left;width:25px">Rp.</div>
                              <div style="text-align:right;width:120px">{{ Number(detail_ahs.HP_Adjust).toLocaleString('id-ID') }}</div>
                              </v-layout>
                            </v-flex>
                            <!-- <v-flex xs2> 
                              <div class="caption grey--text">Status</div>
                              <div>{{ detail_ahs.status }}</div>
                            </v-flex> -->
                          </v-layout>
                        </v-list-item-content>
                        <v-icon color="cyan accent-2" @click="dialog6=true;itemDetail(detail_ahs)">delete</v-icon>
                      </template>
                      <!-- dialog delete detail -->
                        <v-dialog v-model="dialog6" max-width="290px">
                          <v-card>
                            <v-card-title class="headline">Confirmation</v-card-title>
                              <v-card-text>Are you sure want to delete this task?</v-card-text>
                            <v-card-actions>
                              <v-spacer></v-spacer>
                              <v-btn color="green darken-1" text @click="dialog6 = false; deleteDetail(detail.id_ahs_lokal)">Yes</v-btn>
                              <v-btn color="red darken-1" text @click="dialog6 = false">No</v-btn>
                            </v-card-actions>
                          </v-card>
                        </v-dialog>
                      <!--  -->
                    </v-list-group>
                  </v-list-group>
                </v-list-group>
              </template>
            </v-list-group>
          </template>
        </v-list-group>
        <div>
          <v-pagination
            v-model="current_page"
            class="my-4"
            :length="total_pages"
            prev-icon="arrow_left"
            next-icon="arrow_right"
            circle
            @input="getPagination"
            :total-visible="5"
          >
          </v-pagination>
        </div>
      </v-card>

      <v-dialog v-model="dialog2" max-width="290px">
        <v-card>
          <v-card-title class="headline">Confirmation</v-card-title>
            <v-card-text>Are you sure want to delete this rab?</v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="dialog2 = false; deleteItem(rab.id_rab)">Yes</v-btn>
            <v-btn color="red darken-1" text @click="dialog2 = false">No</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
    <v-snackbar v-model="snack" :timeout="3000" :color="snackColor" :top="y === 'top'">
      <v-icon dark>done</v-icon>
      {{ snackText }}
    </v-snackbar>
  </v-app>
</template>

<script>
import Controller from './../service/Project'
import ahsController from './../service/AHS'
import rabController from './../service/RAB'
import rabDetails from './../service/AHSLokal'
import structure from './../service/Structure'
import groups from './../service/Group'
import task from './../service/TaskSub'
import detail from './../service/Details'
import job from './../service/Job'
import material from './../service/Material'

  export default {
    data (){
      return{
        current_page: 1,
        total_pages: 0,

        snack: false,
        y: 'top',
        snackColor: '',
        snackText: '',
        search:'',
        
        dialog: false,
        dialog2: false,
        dialog3: false,
        dialog4: false,
        dialog5: false,
        dialog6: false,
        dialog7: false,
        dialog8: false,
        
        dialogdeletestructure: false,
        dialogdeletefloor: false,
        dialogdeletetask: false,
        dialogdeletedetail: false,

        tambah: false,
        editList:false,

        tambahS: false,
        tambahF: false,
        tambahT: false,

        detailCard: false,
        adjustM: false,
        loading: false,
        detailstructure: false,

        job:[],
        project: [],
        ahs: [],
        material:[],
        RAB:[],
        detailsData: [],

        filterAHSAll:[],
        filterMaterialsAll:[],
        filterProject:[],
        filterStructure:[],
        filterGroup:[],
        filterTaskGroup:[],

        Material:[],
        Structure:[],
        structure:[],
        detailStructure:[],

        Groups:[],
        sub: [],
        detailGroup:[],

        TaskSub:[],
        type:[],
        task:[],
        detailTask:[],

        details:[],
        detailDetails:[],

        detail:{
          id_structure_details: '',
          id_group_details:'',
          id_sub_details:'',
          id_ahs_lokal:''
        },
        structure_unit:{
          id_structure: '',
        },
        group_unit:{
          id_structure:'',
          id_groups: '',
        },
        tasksub_unit:{
          id_structure:'',
          id_groups:'',
          id_sub:'',
        },
        structure_data:{
          id_structure: '',
        },
        group_data:{
          id_structure:'',
          id_groups: '',
        },
        tasksub_data:{
          id_structure:'',
          id_groups:'',
          id_sub:'',
        },
        ahs_lokal:{
          id_structure:'',
          id_groups:'',
          id_sub:'',
          id_ahs:'',
          name:'',
          id_sub_details:'',
          id_job:'',
          total_labor: 0,
          total_material: 0,
          HSP:0,
          volume: 0,
          adjustment: 1,
          HP: 0,
          HP_Adjust:0
        },
        AHSLokalDefault:{
          id_ahs_lokal:'',
          id_sub_details:'',
          id_job:'',
          total_labor: 0,
          total_material: 0,
          HSP:0,
          volume: 0,
          adjustment: 1,
          HP: 0,
          HP_Adjust: 0,
        },
        AHS:{
          id_ahs:'',
          total:0,
        },
        AHSDefault:{
          id_ahs:'',
          total:0,
        },
        rab:{
          id_rab:'',
          id_project:'',
          total_rab:0,
          kode:'',
          desc: '',
        },
        RABDefault:{
          id_rab:'',
          id_project:'',
          id_ahs:'',
          coefficient: 1,
          total_rab:0,
          kode:'',
          desc: '',
        },
        Project: {
          name:'',
          date: new Date().toISOString().substr(0, 10),
          address: '',
          contact: '',
          id_project: '',
          phone: '',
        },
        headers_filter_materials: [
          {text: 'ID', align: 'left', sortable: false, value: 'kode'},
          {text: 'Type', align: 'left', sortable: true, value: 'status'},
          {text: 'Item', align: 'left', sortable: false, value: 'name'},
          {text: 'Price', align: 'left', sortable: false, value: 'price'},
          {text: 'Coefficient', align: 'left', sortable: false, value: 'coefficient'},
          {text: 'Sub Total', align: 'left', sortable: false, value: 'sub_total'},
          {text: 'Adjustment', align: 'left', sortable: false, value: 'adjustment'}
        ],
        headers_detail_floor: [
          {text: 'ID', align: 'left', sortable: false, value: 'id_groups'},
          {text: 'Building', align: 'left', sortable: false, value: 'structure'},
          {text: 'Floor', align: 'left', sortable: false, value: 'floor'},
          {text: 'Task Group', align: 'left', sortable: false, value: 'action'}
        ],
        headers_detail_task: [
          {text: 'ID', align: 'left', sortable: false, value: 'id_sub'},
          {text: 'Building', align: 'left', sortable: false, value: 'structure'},
          {text: 'Floor', align: 'left', sortable: false, value: 'floor'},
          {text: 'Task Group', align: 'left', sortable: false, value: 'task'},
          {text: 'Detail', align: 'left', sortable: false, value: 'action'}
        ],
        headers_detail_building: [
          {text: 'ID', align: 'left', sortable: false, value: 'id_structure'},
          {text: 'Building', align: 'left', sortable: false, value: 'structure'},
          {text: 'Floor', align: 'left', sortable: false, value: 'action'},
        ],
        headers_building_details:[
          {text: 'ID',value:'id_structure'},
          {text: 'Building', value:'structure'},
          {text: 'Actions',value:'action'}
        ],
        headers_ahs_details:[
          {text: 'ID',value:'id_ahs_lokal'},
          {text: 'Builiding',value:'structure'},
          {text: 'Floor',value:'floor'},
          {text: 'Task Group',value:'task'},
          {text: 'AHS',value:'name'},
          {text: 'HSP', value: 'HSP'},
          {text: 'Volume',value:'volume'},
          {text: 'Adjustment',value:'adjustment'},
          {text: 'HP',value:'HP'},
          {text: 'HP_Adjust',value:'HP_Adjust'}
        ],
        tab : 'tab-1',
      }
    },
    mounted(){
      this.getallDetails()
      this.getallItem()
      this.getallAHS()
      this.getallRAB()
      this.getGroup()
      this.getTaskSub()
      this.getStructure()
      this.getJob()
      this.getMaterial()
      this.getPagination()
      this.getall()
      this.getKode()
    },
    computed: {
      filtered:function(){
        return this.RAB.filter((data)=>{    
          return data.project.match(this.search);
        });
      },
    },
    methods: {
      save(){
        this.snack = true
        this.snackColor = 'green darken-1'
        this.snackText = 'Data Save Successfully'
      },
      update(){
        this.snack = true
        this.snackColor = 'teal darken-1'
        this.snackText = 'Data Update Successfully'
      },
      delete(){
        this.snack = true
        this.snackColor = 'red darken-1'
        this.snackText = 'Data Delete Successfully'
      },
      cancel () {
        this.snack = true
        this.snackColor = 'blue'
        this.snackText = 'Canceled'
        this.editList = false
      },
      change(){
        if(this.AHS.id_ahs != '')
        {
          let data = this.ahs.find(obj=>obj.id_ahs == this.AHS.id_ahs)
          this.ahs_lokal.HP = parseFloat(data.total * this.ahs_lokal.volume).toFixed(2)
        }
      },
      adjust(){
        if(this.AHS.id_ahs != '')
        {
          let data = this.ahs.find(obj=>obj.id_ahs == this.AHS.id_ahs)
          this.ahs_lokal.HP_Adjust = 0
          this.ahs_lokal.HP_Adjust = parseFloat(this.ahs_lokal.adjustment * data.total * this.ahs_lokal.volume).toFixed(2)
        }
      },
      async getPagination()
      {
        try{
            await rabController.pagination(this.current_page).then(response => {
            this.current_page = response.meta.pagination.current_page
            this.RAB = response.data
            this.total_pages = response.meta.pagination.total_pages
          })
        }catch(err){
          console.log(err)
        }
      },
      itemDetail(detail)
      {
        this.detail = detail
        console.log('detail')
        console.log(this.detail)
      },
      async itemEdit(item){
        this.init()
        let tempS=[]
        let tempG=[]
        let tempT=[]
        let tempM=[]

        // this.edit = true
        this.rab = item
        // console.log(item)
        this.rab.id_project = item.id_project
        this.rab.total_rab = item.total
        console.log('item')
        console.log(this.rab)
        console.log('total rab')
        console.log(this.rab.total_rab)

        tempS = item.structure.data
        for(let detailS of tempS)
        {
          let structure = {
            id_structure_details: detailS.id_structure_details,
            id_structure : detailS.id_structure
          }
          let detail = {
            id_structure_details: detailS.id_structure_details,
            id_structure : detailS.id_structure,
            structure    : detailS.structure
          }
          this.Structure.push(structure)
          this.detailStructure.push(detail)
        }

        for(let detailG of tempS)
        {
          for(let detailgroup of detailG.group.data)
          {
            let group = {
              id_group_details : detailgroup.id_group_details,
              id_structure  : detailgroup.id_structure,
              id_groups     : detailgroup.id_groups
            }
            let detail = {
              id_group_details : detailgroup.id_group_details,
              id_structure  : detailgroup.id_structure,
              id_groups     : detailgroup.id_groups,
              structure     : detailgroup.structure,
              floor         : detailgroup.floor
            }
            this.Groups.push(group)
            this.detailGroup.push(detail)
            tempG.push(detailgroup)
          }
        }
        for(let detailT of tempG)
        {
          for(let detailtask of detailT.task_sub.data)
          {
            let task = {
              id_sub_details : detailtask.id_sub_details,
              id_structure : detailtask.id_structure,
              id_groups    : detailtask.id_groups,
              id_sub       : detailtask.id_sub
            }
            let detail = {
              id_sub_details : detailtask.id_sub_details,
              id_structure  : detailtask.id_structure,
              id_groups     : detailtask.id_groups,
              id_sub        : detailtask.id_sub,
              structure     : detailtask.structure,
              floor         : detailtask.floor,
              task          : detailtask.task
            }
            this.TaskSub.push(task)
            this.detailTask.push(detail)
            tempT.push(detailtask)
          }
        }
        for(let detailD of tempT)
        {
          for(let ahs of detailD.rab_details.data)
          {
            let ahsN = {
              id_ahs_lokal : ahs.id_ahs_lokal,
              id_structure : ahs.id_structure,
              id_groups : ahs.id_groups,
              id_sub : ahs.id_sub,
              id_ahs : ahs.id_ahs,
              name : ahs.name,
              id_sub_details : ahs.id_sub_details,
              id_job : ahs.id_job,
              total_labor : ahs.total_labor,
              total_material : ahs.total_material,
              total_equipment : ahs.total_equipment,
              HSP_before_overhead: ahs.HSP_before_overhead,
              overhead: ahs.overhead, 
              HSP : ahs.HSP,
              volume : ahs.volume,
              adjustment : ahs.adjustment,
              HP : parseFloat(ahs.HP).toFixed(2),
              HP_Adjust : parseFloat(ahs.HP_Adjust).toFixed(2),
            }
            
            let detail = {
              id_ahs_lokal : ahs.id_ahs_lokal,
              id_structure : ahs.id_structure,
              id_groups : ahs.id_groups,
              id_sub : ahs.id_sub,
              structure : ahs.structure,
              floor : ahs.floor,  
              task : ahs.task,
              id_job : ahs.id_job,
              id_ahs : ahs.id_ahs,
              name : ahs.name
            }
            this.details.push(ahsN)
            this.detailDetails.push(detail)
            tempM.push(ahs)
          }
          console.log('Temp M')
          console.log(tempM)
          this.Material=[]
          console.log('Material')
          console.log(this.Material)
          for(let material of tempM)
          {
            for(let detail of material.detail.data)
            {
              let each_materials = {
                id_ahs_lokal_details : detail.id_ahs_lokal_details,
                id_structure  : detail.id_structure,
                id_groups     : detail.id_groups,
                id_sub        : detail.id_sub,
                id_ahs        : detail.id_ahs,
                id_job        : detail.id_job,    
                id_material   : detail.id_material,
                kode          : detail.kode,
                coefficient   : detail.coefficient,
                sub_total     : detail.sub_total,
                adjustment    : detail.adjustment
              }
              this.Material.push(each_materials)
            }
          }
        }
        console.log('item')
        console.log(item)
        console.log('This Structure')
        console.log(this.Structure)
        console.log('This Detail Structure')
        console.log(this.detailStructure)
        console.log('This Groups')
        console.log(this.Groups)
        console.log('This Detail Group')
        console.log(this.detailGroup)
        console.log('This Task Sub')
        console.log(this.TaskSub)
        console.log('This Detail Task')
        console.log(this.detailTask)
        console.log('This Details')
        console.log(this.details)
        console.log('This Detailss')
        console.log(this.detailDetails)
        console.log('This Material')
        console.log(this.Material)
      },
      itemDelete(item)
      {
        this.detail = item
        this.structure_data = item
        this.group_data = item
        this.tasksub_data = item
        this.ahs_lokal = item
      },
      itemDeleteRAB(item)
      {
        this.rab = item
      },
      async filterProjects()
      {
        // let RAB = (await rabController.getall()).data
        let RAB = (await rabController.getall()).data
        console.log(RAB)
        let project = this.project
        this.filterProject = this.project
        
        for(let rab of RAB)
        {
          this.filterProject = project.filter(obj=>obj.id_project != rab.id_project)
          project = this.filterProject
        }
        console.log(this.filterProject)
      },
      filterStructures()
      {
        this.structure_data.id_structure = ''
        this.filterStructure = this.structure
        let st = this.structure
        console.log("Structure")
        console.log(this.Structure)
        for(let structure of this.Structure)
        {
          this.filterStructure = st.filter(obj=>obj.id_structure != structure.id_structure) 
          st = this.filterStructure
        }
      },
      filterGroups(item)
      {
        this.group_data.id_groups = ''
        this.structure_unit = item
        this.filterGroup = this.sub
        let sub = this.sub
        let Groups = this.Groups.filter(obj=>obj.id_structure == this.structure_unit.id_structure)
        console.log('Groups')
        console.log(Groups)
        for(let group of Groups)
        {
          this.filterGroup = sub.filter(obj=>obj.id_group != group.id_groups)
          sub = this.filterGroup
        }
        console.log('this filter groups')
        console.log(this.filterGroup)
      },
      filterTaskGroups(item)
      {
        this.tasksub_data.id_sub = ''
        this.group_unit = item
        this.filterTaskGroup = this.type
        let type = this.type
        let Task = this.TaskSub.filter(obj=>obj.id_structure == this.group_unit.id_structure && obj.id_groups == this.group_unit.id_groups)

        for(let task of Task)
        {
          this.filterTaskGroup = type.filter(obj=>obj.id_sub != task.id_sub)
          type = this.filterTaskGroup
        }
      },
      filterAHS(item)
      {
        this.AHS = Object.assign({},this.AHSDefault)
        this.ahs_lokal = Object.assign({},this.AHSLokalDefault)

        this.tasksub_unit = item
        this.filterAHSAll = this.ahs.filter(obj=>obj.id_sub == item.id_sub)
        let Detail = this.details.filter(obj=>obj.id_structure == this.tasksub_unit.id_structure && obj.id_groups == this.tasksub_unit.id_groups && obj.id_sub == this.tasksub_unit.id_sub)
        console.log('ahs id sub sama')
        console.log(this.filterAHSAll)
        console.log('Detail')
        console.log(Detail)
        for(let detail of Detail)
        {
          this.filterAHSAll = this.filterAHSAll.filter(obj=>obj.id_ahs != detail.id_ahs)
        }
        console.log('Filter AHS ')
        console.log(this.filterAHSAll)
      },
      getMaterialDetails(){
        if(this.ahs_lokal.adjusment != '')
        {
          let filterMaterials=[]

          let data = this.ahs.find(obj=>obj.id_ahs == this.AHS.id_ahs)
          for(let materials of data.ahs_details.data)
          {
            let each_materials = {
              // id_ahs        : materials.id_ahs,
              id_job        : data.id_job,    
              id_material   : materials.id_material,
              kode          : materials.kode,
              status        : materials.status,
              name          : materials.name,
              price         : materials.price,
              coefficient   : materials.coefficient,
              sub_total     : materials.sub_total,
              adjustment    : this.ahs_lokal.adjustment
            }
            filterMaterials.push(each_materials)
          }
          this.filterMaterialsAll = filterMaterials
          console.log('ini filter material')
          console.log(this.filterMaterialsAll)
        }
      },
      async addstructure()
      {
        let data = this.structure.find(obj=>obj.id_structure == this.structure_data.id_structure)
        let structure = {
          id_structure_details: null,
          id_structure : this.structure_data.id_structure
        }
        let detail = {
          id_structure_details: null,
          id_structure : this.structure_data.id_structure,
          structure    : data.name
        }
        this.Structure.push(structure)
        this.detailStructure.push(detail)
        // this.structure_data.id_structure = ''

        console.log('Detail Structure')
        console.log(this.Structure)
        console.log('Detail Structures')
        console.log(this.detailStructure)
      },
      itemstructure(index,detail)
      {
        this.editList = true
        this.filterStructures()
      },
      editstructure(index,detail)
      {
        let data = this.structure.find(obj=>obj.id_structure == this.structure_data.id_structure)
        let indexstructure = this.detailStructure.find(obj=>obj.id_structure == detail.id_structure)
        let Groups = this.Groups.filter(obj=>obj.id_structure == detail.id_structure) 
        let Task = this.TaskSub.filter(obj=>obj.id_structure == detail.id_structure)
        let Detail = this.details.filter(obj=>obj.id_structure == detail.id_structure)
        let DetailGroup = this.detailGroup.filter(obj=>obj.id_structure == detail.id_structure)
        let DetailTask = this.detailTask.filter(obj=>obj.id_structure == detail.id_structure)
        let Details = this.detailDetails.filter(obj=>obj.id_structure == detail.id_structure)

        let structure = {
          id_structure_details : detail.id_structure_details,
          id_structure : this.structure_data.id_structure        
        }
        let detail_structure = {
          id_structure_details: detail.id_structure_details,
          id_structure : this.structure_data.id_structure,
          structure : data.name
        }
        this.Structure.splice(index,1,structure)
        this.detailStructure.splice(this.detailStructure.indexOf(indexstructure),1,detail_structure)

        for(let group of Groups)
        {
          let each = {
            id_group_details: group.id_group_details,
            id_structure : this.structure_data.id_structure,
            id_groups : group.id_groups       
          }
          this.Groups.splice(this.Groups.indexOf(group),1,each)
        }
        for(let task of Task)
        {
          let each = {
            id_sub_details : task.id_sub_details,
            id_structure : this.structure_data.id_structure,
            id_groups    : task.id_groups,
            id_sub       : task.id_sub
          }
          this.TaskSub.splice(this.TaskSub.indexOf(task),1,each)
        }
        for(let detail of Detail)
        {
          let ahs = {
            id_ahs_lokal : detail.id_ahs_lokal,
            id_structure : this.structure_data.id_structure,
            id_groups : detail.id_groups,
            id_sub : detail.id_sub,
            id_ahs : detail.id_ahs,
            name : detail.name,
            id_sub_details : detail.id_sub,
            id_job : detail.id_job,
            total_labor : detail.total_labor,
            total_material : detail.total_material,
            HSP : detail.HSP,
            volume : detail.volume,
            adjustment : detail.adjustment,
            HP : detail.HSP * detail.volume,
            HP_Adjust : detail.HSP * detail.volume * detail.adjustment,
          }
          this.details.splice(this.details.indexOf(detail),1,ahs)
        }
        for(let group of DetailGroup)
        {
          let detail_group = {
            id_group_details : group.id_group_details,
            id_structure  : this.structure_data.id_structure,
            id_groups     : group.id_groups,
            structure     : data.name,
            floor         : group.floor
          }
          this.detailGroup.splice(this.detailGroup.indexOf(group),1,detail_group)
        }
        for(let task of DetailTask)
        {
          let detail_task = {
            id_sub_details : task.id_sub_details,
            id_structure  : this.structure_data.id_structure,
            id_groups     : task.id_groups,
            id_sub        : task.id_sub,
            structure     : data.name,
            floor         : task.floor,
            task          : task.task
          }
          this.detailTask.splice(this.detailTask.indexOf(task),1,detail_task)
        }
        for(let detail of Details)
        {
          let detailAHS = {
            id_ahs_lokal_details : detail.id_ahs_lokal_details,
            id_structure : this.structure_data.id_structure,
            id_groups : detail.id_groups,
            id_sub : detail.id_sub,
            structure : data.name,
            floor : detail.floor,  
            task : detail.task,
            id_job : detail.id_job,
            id_ahs : detail.id_ahs,
            name : detail.name
          }
          this.detailDetails.splice(this.detailDetails.indexOf(detail),1,detailAHS)
        }
        console.log('Detail Structure')
        console.log(structure)
        console.log('This Structure')
        console.log(this.Structure)
        console.log('This Detail Structure')
        console.log(this.detailStructure)
        console.log('This Groups')
        console.log(this.Groups)
        console.log('This Detail Group')
        console.log(this.detailGroup)
        console.log('This Task Sub')
        console.log(this.TaskSub)
        console.log('This Detail Task')
        console.log(this.detailTask)
        console.log('This Details')
        console.log(this.details)
        console.log('This Detailss')
        console.log(this.detailDetails)

        this.update()
        this.editList = false
      },
      deletestructure(index){
        let structure = this.detailStructure.find(obj=>obj.id_structure == index.id_structure)
        let Groups = this.Groups.filter(obj=>obj.id_structure == index.id_structure) 
        let Task = this.TaskSub.filter(obj=>obj.id_structure == index.id_structure)
        let Detail = this.details.filter(obj=>obj.id_structure == index.id_structure)
        let DetailGroup = this.detailGroup.filter(obj=>obj.id_structure == index.id_structure)
        let DetailTask = this.detailTask.filter(obj=>obj.id_structure == index.id_structure)
        let Details = this.detailDetails.filter(obj=>obj.id_structure == index.id_structure)
        this.Structure.splice(this.Structure.indexOf(index),1)
        this.detailStructure.splice(this.detailStructure.indexOf(structure),1)

        for(let group of Groups)
        {
          this.Groups.splice(this.Groups.indexOf(group),1)
        }
        for(let task of Task)
        {
          this.TaskSub.splice(this.TaskSub.indexOf(task),1)
        }
        for(let detail of Detail)
        {
          this.details.splice(this.details.indexOf(detail),1)
          this.rab.total_rab = parseFloat(this.rab.total_rab - detail.HP_Adjust)
        }
        for(let group of DetailGroup)
        {
          this.detailGroup.splice(this.detailGroup.indexOf(group),1)
        }
        for(let task of DetailTask)
        {
          this.detailTask.splice(this.detailTask.indexOf(task),1)
        }
        for(let detail of Details)
        {
          this.detailDetails.splice(this.detailDetails.indexOf(detail),1)
        }
        console.log('index structure')
        console.log(index)
        console.log('Detail Structure')
        console.log(structure)
        console.log('This Structure')
        console.log(this.Structure)
        console.log('This Detail Structure')
        console.log(this.detailStructure)
        console.log('This Groups')
        console.log(this.Groups)
        console.log('This Detail Group')
        console.log(this.detailGroup)
        console.log('This Task Sub')
        console.log(this.TaskSub)
        console.log('This Detail Task')
        console.log(this.detailTask)
        console.log('This Details')
        console.log(this.details)
        console.log('This Detailss')
        console.log(this.detailDetails)
        
      },
      async addfloor()
      {
        let dataS = this.structure.find(obj=>obj.id_structure == this.structure_unit.id_structure)
        let data = this.sub.find(obj=>obj.id_group == this.group_data.id_groups)
        console.log('hai')
        console.log(dataS)
        console.log(data)
        console.log('end')
        let group = {
          id_group_details : null,
          id_structure  : this.structure_unit.id_structure,
          id_groups     : this.group_data.id_groups
        }
        let detail = {
          id_group_details : null,
          id_structure  : this.structure_unit.id_structure,
          id_groups     : this.group_data.id_groups,
          structure     : dataS.name,
          floor         : data.name
        }
        this.Groups.push(group)
        this.detailGroup.push(detail)
        // this.group_data.id_groups = ''

        console.log('Detail Group')
        console.log(this.Groups)
        console.log('Detail Groups')
        console.log(this.detailGroup)
      },
      itemfloor(index,detail)
      {
        this.editList = true
        this.filterGroups(detail)
      },
      editfloor(index,detail)
      {
        console.log('detail')
        console.log(detail)
        
        let data        = this.sub.find(obj=>obj.id_group == this.group_data.id_groups)
        let Task        = this.TaskSub.filter(obj=>obj.id_structure == detail.id_structure && obj.id_groups == detail.id_groups)
        let Detail     = this.details.filter(obj=>obj.id_structure == detail.id_structure && obj.id_groups == detail.id_groups)
        let group       = this.detailGroup.find(obj=>obj.id_groups == detail.id_groups && obj.id_structure == detail.id_structure)
        let DetailTask  = this.detailTask.filter(obj=>obj.id_structure == detail.id_structure && obj.id_groups == detail.id_groups)
        let Details      = this.detailDetails.filter(obj=>obj.id_structure == detail.id_structure && obj.id_groups == detail.id_groups)

        console.log(Details)
        console.log(Detail)

        let each = {
          id_group_details : detail.id_group_details,
          id_structure : detail.id_structure,
          id_groups : this.group_data.id_groups       
        }
        let detail_group = {
          id_group_details : group.id_group_details,
          id_structure  : group.id_structure,
          id_groups     : this.group_data.id_groups,
          structure     : group.structure,
          floor         : data.name
        }
        this.Groups.splice(index,1,each)
        this.detailGroup.splice(this.detailGroup.indexOf(group),1,detail_group)

        for(let task of Task)
        {
          let each = {
            id_sub_details : task.id_sub_details,
            id_structure : task.id_structure,
            id_groups    : this.group_data.id_groups,
            id_sub       : task.id_sub
          }
          this.TaskSub.splice(this.TaskSub.indexOf(task),1,each)
        }
        for(let detail of Detail)
        {
          let ahs = {
            id_ahs_lokal : detail.id_ahs_lokal,
            id_structure : detail.id_structure,
            id_groups : this.group_data.id_groups,
            id_sub : detail.id_sub,
            id_ahs : detail.id_ahs,
            name : detail.name,
            id_sub_details : detail.id_sub,
            id_job : detail.id_job,
            total_labor : detail.total_labor,
            total_material : detail.total_material,
            HSP : detail.HSP,
            volume : detail.volume,
            adjustment : detail.adjustment,
            HP : detail.HSP * detail.volume,
            HP_Adjust : detail.HSP * detail.volume * detail.adjustment,
          }
          this.details.splice(this.details.indexOf(detail),1,ahs)
        }
        for(let task of DetailTask)
        {
          let detail_task = {
            id_sub_details : task.id_sub_details,
            id_structure  : task.id_structure,
            id_groups     : this.group_data.id_groups,
            id_sub        : task.id_sub,
            structure     : task.structure,
            floor         : data.name,
            task          : task.task
          }
          this.detailTask.splice(this.detailTask.indexOf(task),1,detail_task)
        }
        for(let detail of Details)
        {
          let detailAHS = {
            id_ahs_lokal : detail.id_ahs_lokal,
            id_structure : detail.id_structure,
            id_groups : this.group_data.id_groups,
            id_sub : detail.id_sub,
            structure : detail.structure,
            floor : data.name,  
            task : detail.task,
            id_job : detail.id_job,
            id_ahs : detail.id_ahs,
            name : detail.name
          }
          this.detailDetails.splice(this.detailDetails.indexOf(detail),1,detailAHS)
        }
        this.update()
        this.editList = false
      },
      deletefloor(index){
        let Task        = this.TaskSub.filter(obj=>obj.id_structure == index.id_structure && obj.id_groups == index.id_groups)
        let Details     = this.details.filter(obj=>obj.id_structure == index.id_structure && obj.id_groups == index.id_groups)
        let group       = this.detailGroup.find(obj=>obj.id_groups == index.id_groups && obj.id_structure == index.id_structure)
        let DetailTask  = this.detailTask.filter(obj=>obj.id_structure == index.id_structure && obj.id_groups == index.id_groups)
        let Detail      = this.detailDetails.filter(obj=>obj.id_structure == index.id_structure && obj.id_groups == index.id_groups)

        this.Groups.splice(this.Groups.indexOf(index),1)
        this.detailGroup.splice(this.detailGroup.indexOf(group),1)

        for(let task of Task)
        {
          this.TaskSub.splice(this.TaskSub.indexOf(task),1)
        }
        for(let detail of Details)
        {
            this.rab.total_rab = parseFloat(this.rab.total_rab - detail.HP_Adjust)
            this.details.splice(this.details.indexOf(detail),1)
        }
        for(let task of DetailTask)
        {
          this.detailTask.splice(this.detailTask.indexOf(task),1)
        }
        for(let detail of Detail)
        {
          this.detailDetails.splice(this.detailDetails.indexOf(detail),1)
        }
      },
      async addtasksub()
      {
        let data = this.type.find(obj=>obj.id_sub == this.tasksub_data.id_sub)
        let dataS = this.structure.find(obj=>obj.id_structure == this.group_unit.id_structure)
        let dataG = this.sub.find(obj=>obj.id_group == this.group_unit.id_groups)

        let task = {
          id_sub_details : null,
          id_structure : this.group_unit.id_structure,
          id_groups    : this.group_unit.id_groups,
          id_sub       : data.id_sub
        }
        let detail = {
          id_sub_details : null,
          id_structure  : this.group_unit.id_structure,
          id_groups     : this.group_unit.id_groups,
          id_sub        : data.id_sub,
          structure     : dataS.name,
          floor         : dataG.name,
          task          : data.name
        }
        this.TaskSub.push(task)
        this.detailTask.push(detail)

        console.log('Detail Task')
        console.log(this.TaskSub)
        console.log('Detail Tasks')
        console.log(this.detailTask)

      },
      itemtasksub(index,detail)
      {
        this.editList = true
        this.filterTaskGroups(detail)
      },
      edittasksub(index,detail)
      {
        let data = this.type.find(obj=>obj.id_sub == this.tasksub_data.id_sub)
        let tasks = this.detailTask.find(obj=>obj.id_groups == detail.id_groups && obj.id_structure == detail.id_structure && obj.id_sub == detail.id_sub)
        let Detail = this.details.filter(obj=>obj.id_structure == detail.id_structure && obj.id_groups == detail.id_groups && obj.id_sub == detail.id_sub)
        let Details = this.detailDetails.filter(obj=>obj.id_structure == detail.id_structure && obj.id_groups == detail.id_groups && obj.id_sub == detail.id_sub)
        
        let each = {
          id_sub_details : detail.id_sub_details,
          id_structure : detail.id_structure,
          id_groups    : detail.id_groups,
          id_sub       : this.tasksub_data.id_sub
        }
        this.TaskSub.splice(this.TaskSub.indexOf(detail),1,each)
        
        let detail_task = {
          id_sub_details : detail.id_sub_details,
          id_structure  : tasks.id_structure,
          id_groups     : tasks.id_groups,
          id_sub        : this.tasksub_data.id_sub,
          structure     : tasks.structure,
          floor         : tasks.floor,
          task          : data.name
        }
        this.detailTask.splice(this.detailTask.indexOf(tasks),1,detail_task)
        console.log('This Material Before Splice')
        console.log(this.Material)
        let temp = []

        for(let detail of Detail)
        {
          let filterAHS = this.ahs.filter(obj=>obj.id_sub == this.tasksub_data.id_sub)
          let ahs = filterAHS.find(obj=>obj.id_job == detail.id_job && obj.id_sub == this.tasksub_data.id_sub)
          console.log('AHS Data Replace')
          console.log(ahs)
          if(ahs != undefined)
          {
            console.log('before')
            console.log(this.rab.total_rab)
            console.log('HP Adjust')
            console.log(detail.HP_Adjust)
            this.rab.total_rab = parseFloat(this.rab.total_rab - detail.HP_Adjust)
            console.log('after minus')
            console.log(this.rab.total_rab)
            let new_ahs = {
              id_ahs_lokal : detail.id_ahs_lokal,
              id_structure : detail.id_structure,
              id_groups : detail.id_groups,
              id_sub : this.tasksub_data.id_sub,
              id_ahs : ahs.id_ahs,
              name : ahs.name,
              id_sub_details : this.tasksub_data.id_sub,
              id_job : ahs.id_job,
              total_labor : ahs.total_labor,
              total_material : ahs.total_material,
              HSP : ahs.total,
              volume : detail.volume,
              adjustment : detail.adjustment,
              HP : ahs.total * detail.volume,
              HP_Adjust : ahs.total * detail.volume * detail.adjustment,
            }
            console.log('new AHS')
            console.log(new_ahs.HP_Adjust)
            this.rab.total_rab = parseFloat(this.rab.total_rab + new_ahs.HP_Adjust)
            this.details.splice(this.details.indexOf(detail),1,new_ahs)
            console.log('result')
            console.log(this.rab.total_rab)
            let Temp =[]
            for(let materials of ahs.ahs_details.data)
            {
              let each_materials = {
                id_ahs_lokal_details : null,
                id_structure  : new_ahs.id_structure,
                id_groups     : new_ahs.id_groups,
                id_sub        : new_ahs.id_sub,
                id_ahs        : new_ahs.id_ahs,
                id_job        : new_ahs.id_job,    
                id_material   : materials.id_material,
                kode          : materials.kode,
                coefficient   : materials.coefficient,
                sub_total     : materials.sub_total,
                adjustment    : new_ahs.adjustment
              }
              Temp.push(each_materials)
            }
            let Material = this.Material.filter(obj=>obj.id_ahs == detail.id_ahs)
            console.log('Material Hendak Dihapus')
            console.log(Material)
            console.log('Material Hendak Dipush (new)')
            console.log(Temp)
            let j=0
            for(let material of Material)
            {
              console.log('j')
              console.log(j)
              if(Temp[j] != undefined)
              {
                let data = {
                  id_ahs_lokal_details : material.id_ahs_lokal_details,
                  id_structure  : Temp[j].id_structure,
                  id_groups     : Temp[j].id_groups,
                  id_sub        : Temp[j].id_sub,
                  id_ahs        : Temp[j].id_ahs,
                  id_job        : Temp[j].id_job,    
                  id_material   : Temp[j].id_material,
                  kode          : Temp[j].kode,
                  coefficient   : Temp[j].coefficient,
                  sub_total     : Temp[j].sub_total,
                  adjustment    : Temp[j].adjustment
                }
                console.log('Data')
                console.log(data)
                this.Material.splice(this.Material.indexOf(material),1,data)
                Temp.splice(j,1)
                j++
                console.log('j')
                console.log(j)
                console.log('Sisa Temp')
                console.log(Temp)
              }else{
                this.Material.splice(this.Material.indexOf(material),1)
              }
            }
            console.log('This Material After Splice')
            console.log(this.Material)
            console.log('Sisa Temp All')
            console.log(Temp)

            for(let temp_data of Temp)
            {
              temp.push(temp_data)
            }
          }else{
            console.log('before')
            console.log(this.rab.total_rab)
            console.log('HP Adjust')
            console.log(detail.HP_Adjust)
            this.rab.total_rab = parseFloat(this.rab.total_rab - detail.HP_Adjust)
            this.details.splice(this.details.indexOf(detail),1)
            console.log('result after ahs deleted')
            console.log(this.rab.total_rab)
          }
        }
        console.log('Sisa Temp All in temp')
        console.log(temp)
        for(let material of temp)
        {
          this.Material.push(material)
        }
        for(let detail of Details)
        {
          let filterAHS = this.ahs.filter(obj=>obj.id_sub == this.tasksub_data.id_sub)
          let ahs = filterAHS.find(obj=>obj.name == detail.name)
          if(ahs!=null)
          {
            let detailAHS = {
                id_ahs_lokal : detail.id_ahs_lokal,
                id_structure : detail.id_structure,
                id_groups : detail.id_groups,
                id_sub : this.tasksub_data.id_sub,
                structure : detail.structure,
                floor : detail.floor,  
                task : data.name,
                id_job : ahs.id_job,
                id_ahs : ahs.id_ahs,
                name : ahs.name
              }
              this.detailDetails.splice(this.detailDetails.indexOf(detail),1,detailAHS)
          }else{
            this.detailDetails.splice(this.detailDetails.indexOf(detail),1)
          }
          console.log('This Detailss')
          console.log(this.detailDetails)
          console.log('This Material')
          console.log(this.Material)
        }
        this.update()
        this.editList = false
      },
      deletetasksub(index){
        console.log('index')
        console.log(index)
        let tasks = this.detailTask.find(obj=>obj.id_groups == index.id_groups && obj.id_structure == index.id_structure && obj.id_sub == index.id_sub)
        let Details = this.details.filter(obj=>obj.id_structure == index.id_structure && obj.id_groups == index.id_groups && obj.id_sub == index.id_sub)
        let Detail = this.detailDetails.filter(obj=>obj.id_structure == index.id_structure && obj.id_groups == index.id_groups && obj.id_sub == index.id_sub)
        
        this.TaskSub.splice(this.TaskSub.indexOf(index),1)
        this.detailTask.splice(this.detailTask.indexOf(tasks),1)
        
        for(let detail of Details)
        {
          this.rab.total_rab = parseFloat(this.rab.total_rab - detail.HP_Adjust)
          this.details.splice(this.details.indexOf(detail),1)
        }
        for(let detail of Detail)
        {
          this.detailDetails.splice(this.detailDetails.indexOf(detail),1)
        }
      },
      async addList()
      {
        let data = this.filterAHSAll.find(obj=>obj.id_ahs == this.AHS.id_ahs)
        console.log('hai ahs')
        console.log(data)
        let structure = this.structure.find(obj=>obj.id_structure == this.tasksub_unit.id_structure)
        let floor = this.sub.find(obj=>obj.id_group == this.tasksub_unit.id_groups)
        let tasksub = this.type.find(obj=>obj.id_sub == this.tasksub_unit.id_sub)

        let ahs = {
          id_ahs_lokal : null,
          id_structure : this.tasksub_unit.id_structure,
          id_groups : this.tasksub_unit.id_groups,
          id_sub : this.tasksub_unit.id_sub,
          
          id_ahs : data.id_ahs,
          name : data.name,

          id_sub_details : data.id_sub,
          id_job : data.id_job,
          total_labor : data.total_labor,
          total_material : data.total_material,
          total_equipment : data.total_equipment,
          HSP_before_overhead: data.total_before_overhead,
          overhead: data.overhead,
          HSP : data.total,
          volume : this.ahs_lokal.volume,
          adjustment : this.ahs_lokal.adjustment,
          HP : parseFloat(data.total * this.ahs_lokal.volume).toFixed(2),
          HP_Adjust : parseFloat(data.total * this.ahs_lokal.volume * this.ahs_lokal.adjustment).toFixed(2),
        }
        
        let detail = {
          id_ahs_lokal : null,
          id_structure : this.tasksub_unit.id_structure,
          id_groups : this.tasksub_unit.id_groups,
          id_sub : this.tasksub_unit.id_sub,
          structure : structure.name,
          floor : floor.name,  
          task : tasksub.name,
          id_job : data.id_job,
          id_ahs : data.id_ahs,
          name : data.name
        }
        this.details.push(ahs)
        this.detailDetails.push(detail)

        // let temp = parseFloat(data.total * this.ahs_lokal.volume * this.ahs_lokal.adjustment).toFixed(2)
        this.rab.total_rab = parseFloat(this.rab.total_rab) + parseFloat(ahs.HP_Adjust)
        console.log('total rab')
        console.log(this.rab.total_rab)
        this.tambah = false
        this.detailCard = false

        console.log('Detail AHS')
        console.log(this.details)
        console.log('Detail AHSs')
        console.log(this.detailDetails)
        
        this.addDetails()
        this.AHS = Object.assign({},this.AHSDefault)
        this.ahs_lokal = Object.assign({},this.AHSLokalDefault)
      },
      addDetails()
      {
        let ahs = this.ahs.find(obj=>obj.id_ahs == this.AHS.id_ahs)

        for(let materials of ahs.ahs_details.data)
        {
          let each_materials = {
            id_ahs_lokal_details : null,
            id_structure  : this.tasksub_unit.id_structure,
            id_groups     : this.tasksub_unit.id_groups,
            id_sub        : this.tasksub_unit.id_sub,
            id_ahs        : ahs.id_ahs,
            id_job        : ahs.id_job,    
            id_material   : materials.id_material,
            kode          : materials.kode,
            coefficient   : materials.coefficient,
            sub_total     : materials.sub_total,
            adjustment    : this.ahs_lokal.adjustment
          }
          this.Material.push(each_materials)
        }
        console.log("This Material")
        console.log(this.Material)
      },
      itemList(index,detail)
      {
        this.filterAHS(detail)
        this.editList = true
      },
      editAHS(index,detail)
      {
        let data = this.ahs.find(obj=>obj.id_ahs == this.ahs_lokal.id_ahs)
        let detail_ahs = this.detailDetails.find(obj=>obj.id_structure == detail.id_structure && obj.id_groups == detail.id_groups && obj.id_sub == detail.id_sub && obj.id_ahs == detail.id_ahs) 
        
        let ahs = {
          id_ahs_lokal: detail.id_ahs_lokal,
          id_structure : detail.id_structure,
          id_groups : detail.id_groups,
          id_sub : detail.id_sub,
          id_ahs : this.ahs_lokal.id_ahs,
          name : data.name,
          id_sub_details : detail.id_sub,
          id_job : data.id_job,
          total_labor : data.total_labor,
          total_material : data.total_material,
          total_equipment : data.total_equipment,
          HSP_before_overhead : data.total_before_overhead,
          overhead: data.overhead,
          HSP : data.total,
          volume : detail.volume,
          adjustment : detail.adjustment,
          HP : parseFloat(data.total * detail.volume).toFixed(2),
          HP_Adjust : parseFloat(data.total * detail.volume * detail.adjustment).toFixed(2),
        }
        
        let detailAHS = {
          id_ahs_lokal: detail.id_ahs_lokal,
          id_structure : detail_ahs.id_structure,
          id_groups : detail_ahs.id_groups,
          id_sub : detail_ahs.id_sub,
          structure : detail_ahs.structure,
          floor : detail_ahs.floor,  
          task : detail_ahs.task,
          id_job : data.id_job,
          id_ahs : this.ahs_lokal.id_ahs,
          name : data.name
        }
        console.log('this')
        console.log(this.rab.total_rab)
        console.log(ahs.HP_Adjust)
        console.log(detail.HP_Adjust)
        this.rab.total_rab = parseFloat(this.rab.total_rab)  - parseFloat(detail.HP_Adjust)
        this.details.splice(index,1,ahs)
        this.detailDetails.splice(this.detailDetails.indexOf(detail_ahs),1,detailAHS)
        this.rab.total_rab = parseFloat(this.rab.total_rab) + parseFloat(ahs.HP_Adjust)
        console.log('after edit')
        console.log(this.rab.total_rab)
        let Temp =[]
        for(let materials of data.ahs_details.data)
        {
          let each_materials = {
            id_ahs_lokal_details : null,
            id_structure  : ahs.id_structure,
            id_groups     : ahs.id_groups,
            id_sub        : ahs.id_sub,
            id_ahs        : ahs.id_ahs,
            id_job        : ahs.id_job,     
            id_material   : materials.id_material,
            kode          : materials.kode,
            coefficient   : materials.coefficient,
            sub_total     : materials.sub_total,
            adjustment    : ahs.adjustment
          }
          Temp.push(each_materials)
        }
        let Material = this.Material.filter(obj=>obj.id_ahs == detail.id_ahs)
        console.log('Material Hendak Dihapus')
        console.log(Material)
        console.log('Material Hendak Dipush (new)')
        console.log(Temp)
        let j=0
        for(let material of Material)
        {
          console.log('j')
          console.log(j)
          if(Temp[j] != undefined)
          {
            let data = {
              id_ahs_lokal_details : material.id_ahs_lokal_details,
              id_structure  : Temp[j].id_structure,
              id_groups     : Temp[j].id_groups,
              id_sub        : Temp[j].id_sub,
              id_ahs        : Temp[j].id_ahs,
              id_job        : Temp[j].id_job,    
              id_material   : Temp[j].id_material,
              kode          : Temp[j].kode,
              coefficient   : Temp[j].coefficient,
              sub_total     : Temp[j].sub_total,
              adjustment    : Temp[j].adjustment
            }
            console.log('Data')
            console.log(data)
            this.Material.splice(this.Material.indexOf(material),1,data)
            Temp.splice(j,1)
            j++
            console.log('j')
            console.log(j)
            console.log('Sisa Temp')
            console.log(Temp)
          }else{
            this.Material.splice(this.Material.indexOf(material),1)
          }
        }
        console.log('This Material After Splice')
        console.log(this.Material)
        console.log('Sisa Temp All')
        console.log(Temp)

        for(let temp_data of Temp)
        {
          this.Material.push(temp_data)
        }
        this.editList = false
        this.update()
        console.log('This Detail')
        console.log(this.details)
        console.log('This Detailss')
        console.log(this.detailDetails)
        console.log('This Material')
        console.log(this.Material )
      },
      editvolumeadjust(index,detail)
      {
        let ahs = {
          id_ahs_lokal: detail.id_ahs_lokal,
          id_structure : detail.id_structure,
          id_groups : detail.id_groups,
          id_sub : detail.id_sub,
          id_ahs : detail.id_ahs,
          name : detail.name,
          id_sub_details : detail.id_sub,
          id_job : detail.id_job,
          total_labor : detail.total_labor,
          total_material : detail.total_material,
          total_equipment : detail.total_equipment,
          HSP_before_overhead : detail.HSP_before_overhead,
          overhead: detail.overhead,
          HSP : detail.HSP,
          volume : detail.volume,
          adjustment : detail.adjustment,
          HP : parseFloat(detail.HSP * detail.volume).toFixed(2),
          HP_Adjust : parseFloat(detail.HSP * detail.volume * detail.adjustment).toFixed(2),
        }
        this.rab.total_rab = parseFloat(this.rab.total_rab) - parseFloat(detail.HP_Adjust)
        console.log(this.rab.total_rab)
        this.details.splice(index,1,ahs)
        this.rab.total_rab = parseFloat(this.rab.total_rab) + parseFloat(ahs.HP_Adjust)
        console.log(this.rab.total_rab)
        for(let material of this.Material)
        {
          let each = {
            id_ahs_lokal_details : material.id_ahs_lokal_details,
            id_structure : material.id_structure,
            id_groups : material.id_groups,
            id_sub : material.id_sub,
            id_ahs : material.id_ahs,
            id_job : material.id_job,
            id_material : material.id_material,
            kode : material.kode,
            coefficient : material.coefficient,
            sub_total : material.sub_total,
            adjustment : detail.adjustment            
          }
          this.Material.splice(this.Material.indexOf(material),1,each)
        }
        this.update()
        console.log('This Detail')
        console.log(this.details)
        console.log('This Detailss')
        console.log(this.detailDetails)
        console.log('This Material')
        console.log(this.Material)
      },
      deleteList(index){
        let data = this.details.find(obj=>obj.id_structure == index.id_structure && obj.id_groups == index.id_groups && obj.id_sub == index.id_sub && obj.id_ahs == index.id_ahs)
        console.log(data)
        let detail = this.detailDetails.find(obj=>obj.id_structure == index.id_structure && obj.id_groups == index.id_groups && obj.id_sub == index.id_sub && obj.id_ahs == index.id_ahs) 
        let material = this.Material.filter(obj=>obj.id_structure == index.id_structure && obj.id_groups == index.id_groups && obj.id_sub == index.id_sub && obj.id_ahs == index.id_ahs)
        this.rab.total_rab = parseFloat(this.rab.total_rab - index.HP_Adjust).toFixed(2)
        this.details.splice(this.details.indexOf(data),1)
        this.detailDetails.splice(this.detailDetails.indexOf(detail),1)

        console.log('all material in ahs')
        console.log(material)

        for(let each of material)
        {
          this.Material.splice(this.Material.indexOf(each),1)
        }
        // this.AHS = Object.assign({},this.AHSDefault)
        // this.ahs_lokal = Object.assign({},this.AHSLokalDefault)
        console.log('Detail Structure')
        console.log(this.Structure)
        console.log('Detail Group')
        console.log(this.Groups)
        console.log('Detail Task')
        console.log(this.TaskSub)
        console.log('Detail AHS')
        console.log(this.details)
        console.log('Detail Structures')
        console.log(this.detailStructure)
        console.log('Detail Groups')
        console.log(this.detailGroup)
        console.log('Detail Task')
        console.log(this.detailTask)
        console.log('Detail AHSs')
        console.log(this.detailDetails)
        console.log('This Material')
        console.log(this.Material)
      },
      async getStructure(){
        try{
          this.structure = (await structure.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async getGroup(){
        try{
          this.sub = (await groups.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async getTaskSub(){
        try{
          this.type = (await task.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallDetails(){
        try{
          this.detailsData = (await rabDetails.get()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallAHS(){
        try{
          this.ahs = (await ahsController.getall()).data
        }catch(err){
          console.log(err)
        }
      },
      async getallItem(){
        try{
          this.project = (await Controller.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async getKode(){
        try{
          this.rab.kode = (await rabController.getKode())
        }catch(err){
          console.log(err)
        }
      },
      async getallRAB(){
        try{
          this.RAB = (await rabController.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async getall(){
        try{
          let rab = (await rabController.getall()).data
        }catch(err){
          console.log(err)
        }
      },
      async addAllItem(){
        try{
          this.loading = true
          const payload = {
            id_project        : this.rab.id_project,
            kode              : this.rab.kode,
            desc              : this.rab.desc,
            total_rab         : this.rab.total_rab,
            detail_structure  : this.Structure,
            detail_group      : this.Groups,
            detail_task       : this.TaskSub,
            detail            : this.details,
            detail_material   : this.Material
          }
          await rabController.addAllItem(payload).then(response=>{
            this.getallRAB()
            // this.getall()
            this.loading = false
            this.close()
            this.save()
          })
        }catch(err){
          this.loading = false
          console.log(err);
        }
      },
      async updateItem(id){
        try{
          this.loading = true
          const payload = {
            id_project        : this.rab.id_project,
            kode              : this.rab.kode,
            desc              : this.rab.desc,
            total_rab         : this.rab.total_rab,
            detail_structure  : this.Structure,
            detail_group      : this.Groups,
            detail_task       : this.TaskSub,
            detail            : this.details,
            detail_material   : this.Material
          } 
          await rabController.updateItem(payload,id).then(response=>{
            this.getPagination()
            this.loading = false
            this.close()
            this.update()
          })
        }catch(err){
          this.loading = false
          console.log(err);
        }
      },
      async deleteItem(id){
        try{
          await rabController.deleteItem(id).data
          this.getPagination()
          this.delete()
        }catch(err){
          console.log(err)
        }
      },
      async deleteDetail(id){
        try{
          let rabdetails = this.detailsData.find(obj=>obj.id_ahs_lokal == id)
          await rabDetails.delete(id).data
          this.getPagination()
          this.delete()
        }catch(err){
          console.log(err)
        }
      },
      async deleteStructureDetails(id)
      {
        try{
          let structure = this.Structure.find(obj=>obj.id_structure_details == id)
          await detail.deleteS(id).data
          this.getPagination()
          this.delete()
        }catch(err){
          console.log(err)
        }
      },
      async deleteGroupDetails(id)
      {
        try{
          let group = this.Groups.find(obj=>obj.id_group_details == id)
          console.log(group)
          await detail.deleteG(id).data
          this.getPagination()
          this.delete()
        }catch(err){
          console.log(err)
        }
      },
      async deleteTaskDetails(id)
      {
        try{
          let task = this.TaskSub.find(obj=>obj.id_sub_details == id)
          await detail.deleteT(id).data
          this.getPagination()
          this.delete()
        }catch(err){
          console.log(err)
        }
      },
      async getJob()
      {
        try{
          this.job = (await job.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      async getMaterial()
      {
        try{
          this.material = (await material.getallItem()).data
        }catch(err){
          console.log(err)
        }
      },
      reset(){
        this.getKode()
        this.filterProjects()
        this.rab.id_project = ''
        this.rab.desc = ''
        this.rab.total_rab = 0
        this.init()
      },
      init(){
        this.Material=[]
        this.Structure=[]
        this.Groups=[]
        this.TaskSub=[]
        this.details=[]
        this.detailStructure=[]
        this.detailGroup=[]
        this.detailTask=[]
        this.detailDetails=[]
      },
      close () {
        this.dialog = false
        this.dialog7 = false
        this.dialog8 = false
      },
    }
  }
</script>

<style>
.marginBorder{
  margin-left: 10px;
}
.borderRab{
  border-left: 4px solid #1565C0
}
.borderStructure{
  /* margin-left: 10px; */
  border-left: 4px solid #0091EA;
}
.borderFloor{
  margin-left: 10px;
  border-left: 4px solid #00B0FF
}
.borderTask{
  margin-left: 20px;
  border-left: 4px solid #4FC3F7
}
.borderDetail{
 margin-left: 30px;
 border-left: 4px solid #18FFFF
}
.dialogEdit{
  min-width: 36px;
  top: 401px;
  left: 392px;
  transform-origin: right top;
  z-index: 204;
}
</style>